/**
 * 本页面用于表单的演示测试之用
 */

const app = getApp()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    form: {},
    radio: {},
    checkbox: {},
    pickerValue: '',
    popupPicker: {},
    fileList: {},
    showDate: {},
    date: {},
    showBind: {}
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


    wx.uploadFile({
      url: '{{siteUrl}}/?m=Upload&a=ueditor&method=POST&action=' + action,
      filePath: file.path,
      name: 'upfile',
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
    console.dir(e.detail.value)
    // app.ajaxSubmit({
    //   url: '/?g=API&m=Index&a=test',
    //   method: 'POST',
    //   data: e.detail.value,
    //   success: function (res) {
    //     console.dir(res)
    //   }
    // });
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

  onLoad: function () {
    var gt = this;

    app.ajaxSubmit({

      url: '/?g=API&m=Index&a=ticketForm&number=FSZUTK5655',
      success(res) {
        // console.dir(res.data.data)
        gt.setData({
          form: res.data.data.field
        })
      },
      fail(res) {

      }
    })

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

      wx.createSelectorQuery().selectAll('.form_' + id).fields({
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

})