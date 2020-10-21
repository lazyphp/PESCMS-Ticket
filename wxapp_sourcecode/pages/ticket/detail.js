import Dialog from '../../miniprogram_npm/@vant/weapp/dialog/dialog';

const app = getApp()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    number:String,
    data: Object,
    error: Object,
    submitLoading: false,
    textarea: '',
    tabbarActive: 1,
    Loading: true,
    title: '工单详情',
    goback: '< 返回',
    templateList: Object,
    contact: String
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

      var number = options.number;

      this.setData({number: number})

      app.getTemplateList(function (res) {
        gt.setData({templateList: res})
      })

      var gt = this;

      app.ajaxSubmit({
        url: '/?g=API&m=Ticket&a=detail&number='+number ,
        data: {
          token: app.getLoginToken(),
          systemInfo: app.data.systemInfo,
          method: 'GET'
        },
        method: 'POST',
        success(res) {
          if (res.data.status == 200) {
            gt.setData({
              data: res.data.data,
              contact:res.data.data.ticket.contact,
              Loading:false
            })
          }else{
            gt.setData({
              data: Object,
              error: res.data.msg || '获取工单信息失败',
              Loading:false
            })
          }
        },
        fail(res){
          gt.setData({
            data: Object,
            error: res || '获取工单信息失败',
            Loading:false
          })
        }
  
      })

  },

  /**
   * 回复工单
   */
  reply(e){
    var gt = this;


    //点击触发订阅消息
    if(gt.data.contact == '6'){
      wx.requestSubscribeMessage({
        tmplIds: [this.data.templateList[2], this.data.templateList[4], this.data.templateList[5]],
        success(res) {}
      })
    }


    if(gt.data.submitLoading == true){
      Dialog.alert({
        title: '系统提示',
        message: '程序正在努力等待回复提交完毕...',
        zIndex: 999
      })
      return false;
    }

    gt.setData({submitLoading: true})

    app.ajaxSubmit({
      url: '/?g=API&m=Ticket&a=reply' ,
      data: {
        number: gt.data.number,
        content: e.detail.value.content,
        token: app.getLoginToken(),
        systemInfo: app.data.systemInfo,
        method: 'POST'
      },
      method: 'POST',
      success(res) {
        gt.setData({submitLoading: false})
        if (res.data.status == 200) {
          gt.setData({textarea:''})
          gt.onLoad({number:gt.data.number});
        }else{
          Dialog.alert({
            title: '系统提示',
            message: res.data.msg || '回复工单失败',
            zIndex: 999
          })
        }
      },
      fail(res){
        gt.setData({
          data: Object,
          error: res || '获取工单信息失败',
          Loading:false
        })
      }

    })

  },

  /**
   * 回到工单列表
   */
  goback(){
    wx.switchTab({
      url: '/pages/ticket/index'
    })
  },

  /**
   * 回顶部
   */
  scrollTop(){
    wx.pageScrollTo({
      scrollTop: 0,
      duration: 300
    })
  },


})