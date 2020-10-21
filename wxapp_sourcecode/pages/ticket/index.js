const app = getApp()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    data: Object,
    ticketStatus: Object,
    error: Object,
    tabbarActive: 1,
    tabs: -1,
    tabsLoading: true,
    title: '工单列表',
    username: '',
    avatar: '',
    signup: String
  },

  /**
   * 切换不同工单状态的列表
   * @param {*} e 
   */
  getTicketStatus(e) {

    if (this.data.tabsLoading == true) {

      var difference = this.data.tabs - e.detail.name;

      this.setData({
        tabs: e.detail.name
      })

      this.setData({
        tabs: e.detail.name + difference
      })

      return false;
    }

    this.setData({
      tabs: e.detail.name
    })

    var status = e.detail.name;

    this.ticketList(status);

  },

  /**
   * 获取我的工单列表
   * @param {*} status 
   */
  ticketList(status) {
    var gt = this;
    var token = app.getLoginToken();

    this.setData({
      data: Object,
      error: Object,
      tabsLoading: true
    });

    app.ajaxSubmit({
      url: '/?g=API&m=Ticket&a=index&status=' + status,
      data: {
        token: token,
        systemInfo: app.data.systemInfo,
        method: 'GET'
      },
      method: 'POST',
      success(res) {
        if (res.statusCode == 200) {
          gt.setData({
            data: res.data.data.list,
            ticketStatus: res.data.data.ticketStatus,
            tabsLoading: false
          })
        }
      },
      fail(res){
        gt.setData({
          data: Object,
          error: res,
          tabsLoading: false
        })
      }

    })
  },

  signup(){
    wx.removeStorage({key:'signupHide'})
    wx.reLaunch({
      url:'/pages/ticket/index'
    })
  },

  onShow() {
    this.ticketList('-1'),
    this.setData({
      username: wx.getStorageSync('username'),
      avatar: wx.getStorageSync('avatar'),
      signup: wx.getStorageSync('signup')
    })
  }

})