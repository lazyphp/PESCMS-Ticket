import Dialog from '../../miniprogram_npm/@vant/weapp/dialog/dialog';

const app = getApp()

/**
 * 页脚复用组件
 */
Component({

  /**
   * 组件的属性列表
   */
  properties: {

  },

  /**
   * 组件的初始数据
   */
  data: {

    //页脚选中标记
    tabbarActive: 0,
    showSignUp: false,
    bindAccount: false,
    accountError: '',
    passwordError: ''
  },

  lifetimes: {
    ready() {
      var pages = getCurrentPages();
      this.setData({
        tabbarActive: pages[0]['data']['tabbarActive']
      });

      if (wx.getStorageSync('signup') == '0' && wx.getStorageSync('signupHide') != '1' ) {
        this.setData({
          showSignUp: true
        });
      }

    },
  },



  /**
   * 组件的方法列表
   */
  methods: {

    /**
     * 导航栏跳转
     * @param {*} event 
     */
    appNavigateTo(event) {
      var url;
      switch (event.detail) {
        case 0:
          url = '/pages/index/index';
          break;
        case 1:
          url = '/pages/ticket/index';
          break;
        case 2:
          url = '/pages/member/index';
          break;
      }

      wx.switchTab({
        url: url
      })

    },

    /**
     * 快速注册
     * @param {*} e 
     */
    quickSignUp(e) {
      var rawData = e.detail.rawData
      if (rawData) {
        this.commonSignUpRequest(rawData)

      } else {
        Dialog.alert({
          message: '您需要同意授权才可以使用快速注册功能',
          zIndex: 999
        })
      }
    },

    /**
     * 点击展示绑定账号页面
     */
    bindAccount() {
      this.setData({
        showSignUp: false,
        bindAccount: true
      });
    },

    /**
     * 操作返回绑定账号动作
     */
    closeBindAccount() {
      this.setData({
        showSignUp: true,
        bindAccount: false
      });
    },

    formSubmit(e) {
      var formData = e.detail.value;

      if (formData.account == '') {
        this.setData({
          accountError: '请填写您要绑定的账号'
        })
        return false;
      }

      if (formData.password == '') {
        this.setData({
          passwordError: '请填写您要绑定的账号密码'
        })
        return false;
      }

      this.commonSignUpRequest(JSON.stringify({
        account: formData.account,
        password: formData.password,
        bingAccount: '1'
      }));

    },

    commonSignUpRequest(data) {

      var gt = this;

      app.ajaxSubmit({
        url: '/?g=API&m=Member&a=signup',
        method: 'POST',
        data: {
          token: app.getLoginToken(),
          systemInfo: app.data.systemInfo,
          data: data
        },
        success: function (res) {
          switch (res.data.status) {
            case 200:
              wx.setStorageSync('username', res.data.data.username)
              wx.setStorageSync('avatar', res.data.data.avatar)
            case 1:
              wx.setStorageSync('signup', 1)
              gt.setData({
                showSignUp: false,
                bindAccount: false
              });
            default:
              Dialog.alert({
                message: res.data.msg,
                zIndex: 999
              })
          }
        }
      });
    },

    closeSingup(){
      wx.setStorageSync('signupHide', '1')
      this.setData({
        showSignUp: false,
      });
    }

  }
})