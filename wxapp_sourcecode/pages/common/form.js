// pages/common/form.js

const app = getApp()

import Toast from '../../miniprogram_npm/@vant/weapp/toast/toast';

Component({

  /**
   * 组件的属性列表
   */
  properties: {
    tNumber: String,
    loading: Boolean
  },

  /**
   * 组件的初始数据
   */
  data: {
    form: Object,
    ticket: Object,
    submitLoading: false,
    showContactInput: true,
    memberContact: Object,
    contactAccount: '',
    radio: {},
    checkbox: {},
    pickerValue: '',
    popupPicker: {},
    fileList: {},
    showDate: {},
    date: {},
    showBind: {},
    templateList: Object
  },

  lifetimes: {

    ready: function () {

      var gt = this;

      var tNumber = this.data.tNumber

      app.getTemplateList(function (res) {
        gt.setData({
          templateList: res
        })
      })

      app.ajaxSubmit({
        url: '/?g=API&m=Index&a=ticketForm&number=' + tNumber,
        data: {
          token: app.getLoginToken(),
          systemInfo: app.data.systemInfo,
          method: 'GET'
        },
        method: 'POST',
        success(res) {

          if (res.data.status == 200) {
            gt.setData({
              ticket: res.data.data.ticket,
              showContactInput: res.data.data.ticket['contact_default'] == '6' ? false : true,
              form: res.data.data.field,
              memberContact: {
                phone: res.data.data.phone || '',
                email: res.data.data.email || '',
              }
            })
          }

          gt.setData({
            loading: false
          })

        },
        fail(res) {
          gt.setData({
            loading: false
          })
        }
      })

    },
  },



  /**
   * 组件的方法列表
   */
  methods: {

    /**
     * 返回上一层
     */
    refresh() {
      this.triggerEvent('stepFunc', 1)
    },

    /**
     * 删除上传的图片
     * @param {*} e 
     */
    removeUpload(e) {
      var name = e.target.dataset.name

      var fileList = this.data.fileList;

      fileList[name].splice(e.detail.index, 1);

      this.setData({
        fileList
      })

    },

    /**
     * 执行上传文件
     * @param {*} e 
     */
    afterRead(e) {

      var gt = this;

      var fileList = this.data.fileList

      var index = e.detail.index;

      var name = e.target.dataset.name

      var type = e.target.dataset.type

      var action = type == 'file' ? 'uploadfile' : 'uploadimage'

      var file = e.detail.file;

      if (!fileList[name]) {
        fileList = Object.assign(fileList, {
          [name]: []
        });
      }

      //上传前的效果提醒
      fileList[name].push({
        url: file.path,
        status: 'uploading',
        message: '上传中',
        deletable: false,
      });

      gt.setData({
        fileList
      })

      let token = app.getLoginToken();
      let systemInfo = app.data.systemInfo;

      wx.uploadFile({
        url: '{{siteUrl}}/?m=Upload&a=ueditor&method=POST&action=' + action,
        filePath: file.path,
        name: 'upfile',
        formData: { token: token, systemInfo: systemInfo },
        success(res) {
          var data = JSON.parse(res.data);

          if (data.state == 'SUCCESS') {
            fileList[name][index]['status'] = 'done'
            fileList[name][index]['message'] = '上传成功';

            if (type == 'file') {
              fileList[name][index]['upload_url'] = '[url=' + data.url + ']' + data.original + '[/url]';
            } else {
              fileList[name][index]['upload_url'] = data.url;
            }

            wx.showToast({
              title: '上传成功',
              icon: 'none'
            });
          } else {
            fileList[name][index]['status'] = 'failed'
            fileList[name][index]['message'] = '上传失败' + data.state;
          }

          fileList[name][index]['deletable'] = true;

          gt.setData({
            fileList
          });
        },
      });
    },


    /**
     * 实时获取拉动下拉菜单的值
     * @param {*} e 
     */
    pickerChange(e) {
      var name = e.target.dataset.name

      var obj = Object.assign(this.data.pickerValue, {
        [name]: e.detail.value
      });

      this.setData({
        pickerValue: obj
      })
    },

    /**
     * 选择当前下拉菜单的内容
     * @param {*} e 
     */
    pickerSelected(e) {
      this.pickerChange(e)
      this.pickerClose(e)
    },

    /**
     * 关闭下拉菜单
     * @param {*} e 
     */
    pickerClose(e) {
      var name = e.target.dataset.name

      var obj = Object.assign(this.data.popupPicker, {
        [name]: false
      });

      this.setData({
        popupPicker: obj
      });
    },

    /**
     * 弹出下拉菜单
     * @param {*} e 
     */
    showPicker(e) {
      var name = e.target.dataset.name

      var obj = Object.assign(this.data.popupPicker, {
        [name]: true
      });

      this.setData({
        popupPicker: obj
      });

    },

    formSubmit(e) {

      if (this.data.submitLoading == true) {
        Toast.fail('工单提交中...');
        return false;
      }

      var data = e.detail.value;

      var gt = this;

      //处理空表单内容
      for (var key in data) {
        if (data[key] == null) {
          data[key] = ''
        }
      }

      data['token'] = app.getLoginToken(),
        data['systemInfo'] = app.data.systemInfo,

        this.setData({
          submitLoading: true
        })

      app.ajaxSubmit({
        url: '/?g=API&m=Ticket&a=submit',
        method: 'POST',
        data: data,
        success: function (res) {

          gt.setData({
            submitLoading: false
          })

          if (res.data.status == 0) {
            wx.showToast({
              title: res.data.msg,
              icon: 'none',
            })
          } else if (res.data.status == 200) {
            Toast.success('工单提交成功!');
            var number = res.data.data;

            //选择小程序留言方式，则检查订阅生效
            if (data.contact == '6') {
              wx.requestSubscribeMessage({
                tmplIds: [gt.data.templateList[1], gt.data.templateList[3], gt.data.templateList[6]],
                success(res) {
                  wx.redirectTo({
                    url: '../../pages/ticket/detail?number=' + number
                  })
                },
                fail(res){
                  wx.redirectTo({
                    url: '../../pages/ticket/detail?number=' + number
                  })
                }
              })
            }else{
              wx.redirectTo({
                url: '../../pages/ticket/detail?number=' + res.data.data
              })
            }

          }
        },
        fail(res) {
          gt.setData({
            data: Object,
            error: res || '获取工单信息失败',
            submitLoading: false
          })
        }
      });
    },

    /**
     * 单选按钮触发点击
     * @param {*} e 
     */
    radioChange(e) {

      var name = e.target.dataset.name

      var obj = Object.assign(this.data.radio, {
        [name]: e.detail
      });

      this.setData({
        radio: obj
      });
    },

    /**
     * 切换联系方式
     */
    changeContact(e) {

      var name = e.currentTarget.dataset.name

      switch (this.data.radio[name]) {
        case '1':
          var showContactInput = true;
          var contactAccount = this.data.memberContact.email;
          break;
        case '2':
          var showContactInput = true;
          var contactAccount = this.data.memberContact.phone;
          break;
        default:
          var contactAccount = '';
          var showContactInput = false;
      }

      this.setData({
        showContactInput: showContactInput,
        contactAccount: contactAccount
      });

    },

    /**
     * 复选框按钮触发点击
     * @param {*} e 
     */
    checkboxChange(e) {
      var name = e.target.dataset.name

      var obj = Object.assign(this.data.radio, {
        [name]: e.detail
      });

      this.setData({
        checkbox: obj
      });

    },

    /**
     * 显示日历
     * @param {*} e 
     */
    displayCalendar(e) {
      var name = e.target.dataset.name

      var obj = Object.assign(this.data.showDate, {
        [name]: true
      });

      this.setData({
        showDate: obj
      });
    },

    /**
     * 关闭日历
     * @param {*} e 
     */
    closeCalendar(e) {
      var name = e.target.dataset.name

      var obj = Object.assign(this.data.showDate, {
        [name]: false
      });

      this.setData({
        showDate: obj
      });
    },

    /**
     * 日期格式化
     * @param {*} date 
     */
    formatDate(date) {
      date = new Date(date);
      return `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`;
    },

    /**
     * 确认选择的日期
     * @param {*} e 
     */
    confirmCalendar(e) {
      var name = e.target.dataset.name

      var obj = Object.assign(this.data.date, {
        [name]: this.formatDate(e.detail)
      });

      this.setData({
        date: obj,
      });

      this.closeCalendar(e)
    },



    /**
     * 联动核心操作
     * @param {*} e 
     */
    linkage: function (e) {

      var gt = this;
      var pageData = this.data;
      var id = e.currentTarget.dataset.id;
      var name = e.currentTarget.dataset.name;
      var option = e.currentTarget.dataset.option || {};

      var selectValue = pageData.radio[name] || JSON.parse(option)[pageData.pickerValue[name]]

      var showBind = {}

      if (selectValue) {
        showBind = {
          [id]: {}
        }

        wx.createSelectorQuery().in(this).selectAll('.form_' + id).fields({
          dataset: true,
        }, function (res) {
          for (var i = 0; i < res.length; i++) {
            var currentID = res[i]['dataset']['id']
            var bindValue = res[i]['dataset']['bindvalue'].split(',')
            if (bindValue.indexOf(selectValue) != -1) {
              Object.assign(showBind[id], {
                [currentID]: true
              });
            } else {
              Object.assign(showBind[id], {
                [currentID]: false
              });
            }

            var obj = Object.assign(gt.data.showBind, showBind)
            gt.setData({
              showBind: obj,
            });
          }
        }).exec()
      }
    }

  }
})