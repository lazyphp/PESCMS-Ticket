// pages/member/index.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    tabbarActive: 2,
    title: '个人中心',
    username: '',
    avatar: ''
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onShow: function (options) {
    this.setData({
      username: wx.getStorageSync('username'),
      avatar: wx.getStorageSync('avatar')
    })
  }

})