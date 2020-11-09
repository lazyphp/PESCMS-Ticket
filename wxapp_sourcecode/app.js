//app.js

import Dialog from '/miniprogram_npm/@vant/weapp/dialog/dialog';

App({

  data: {
    siteUrl: '{{siteUrl}}',
    systemInfo: '',
  },

  onLaunch: function () {

    //全局this
    var gt = this;
    wx.getSystemInfo({
      success(res) {
        gt.data.systemInfo = JSON.stringify({
          benchmarkLevel: res.benchmarkLevel,
          language: res.language,
          safeArea: res.safeArea,
          screenHeight: res.screenHeight,
          windowHeight: res.windowHeight,
          version: res.version,
          system: res.system,
          pixelRatio: res.pixelRatio,
          windowWidth: res.windowWidth,
          model: res.model,
          screenWidth: res.screenWidth,
          brand: res.brand,
          platform: res.platform,
          SDKVersion: res.SDKVersion
        })
      }
    })

    //登录
    wx.checkSession({
      success() {
        gt.authLogin();
      },
      fail() {
        gt.loginAction();
      }
    })

  },

  /**
   * 封装微信请求类
   * @param {*} options 
   */
  ajaxSubmit(options) {

    var gt = this;

    var obj = {
      url: '',
      method: 'GET',
      data: {
        '': ''
      },
      timeout: 60000,
      success: {},
      fail: {},
      skipErrorTips: false //跳过 404 和 500 错误的默认提示
    };

    Object.assign(obj, options);

    wx.request({
      url: this.data.siteUrl + obj.url,
      data: obj.data,
      method: obj.method,
      header: {
        'Accept': 'application/json', // 默认值
        'X-Requested-With': 'XMLHttpRequest',
        'content-type': 'application/x-www-form-urlencoded'
      },
      timeout: obj.timeout,
      success(res) {

        if (res.statusCode == 995) {
          Dialog.alert({
            title: '系统提示',
            message: res.data.msg || '与服务器校验数据失败',
            confirmButtonText: '重新登录',
            zIndex: 999
          }).then(() => {
            gt.loginAction();
          });

          options.fail('与服务器校验数据失败') //通知错误方法

          return false;
        }

        var httpErrorStatus = [401, 403, 404, 500, 501, 502, 503, 504, 505];
        var tmpStatus = res.statusCode || -1

        if (obj.skipErrorTips == false && httpErrorStatus.indexOf(tmpStatus) != -1) {
          Dialog.alert({
            title: '出错了!',
            message: '当前请求出错，SOS ' + tmpStatus,
            zIndex: 999
          })

          options.fail(tmpStatus) //通知错误方法

        } else {
          options.success(res)
        }

      },
      fail(res) {
        if (obj.skipErrorTips == false) {
          Dialog.alert({
            title: '请求失败',
            message: '当前请求出错了，请稍后再试',
            zIndex: 999
          })
        } else {
          options.fail(res)
        }
      }
    })

  },

  /**
   * 执行登录动作
   */
  loginAction() {

    var gt = this;

    wx.login({
      success: res => {
        this.ajaxSubmit({
          url: '/?g=API&m=Member&a=weixinLogin',
          data: {
            code: res.code,
            systemInfo: gt.data.systemInfo
          },
          method: 'POST',
          success: res => {

            switch (res.data.status) {
              case 200:
                wx.setStorageSync('login_token', res.data.data.token)
                wx.setStorageSync('signup', res.data.data.signup)
                wx.setStorageSync('username', res.data.data.username)
                wx.setStorageSync('avatar', res.data.data.avatar)

                wx.reLaunch({
                  url: '/pages/index/index'
                })

                break;
              case -1:
              case 45011:
                Dialog.alert({
                  title: '系统提示',
                  message: res.data.msg || '当前系统繁忙，请稍后再试',
                  zIndex: 999
                })
                break;
              case 40029:
                Dialog.alert({
                  title: '校验异常',
                  message: res.data.msg || '程序校验数据失败，请点击按钮再试',
                  confirmButtonText: '刷新信息',
                  zIndex: 999
                }).then(() => {
                  gt.loginAction();
                });
                break;
              default:
                Dialog.alert({
                  title: '系统提示',
                  message: res.data.msg || '未知错误',
                  zIndex: 999
                })
            }
          },
          fail: res => {}
        })
      }
    })
  },

  /**
   * 判断登录状态
   */
  authLogin() {
    var gt = this;
    var token = this.getLoginToken();

    this.ajaxSubmit({
      url: '/?g=API&m=Member&a=auth',
      data: {
        token: token,
        systemInfo: gt.data.systemInfo
      },
      method: 'POST',
      success(res) {
        switch (res.data.status) {
          case 200:
            wx.setStorageSync('signup', res.data.data.signup)
            wx.setStorageSync('username', res.data.data.username)
            wx.setStorageSync('avatar', res.data.data.avatar)
            break;
          default:
            Dialog.alert({
              title: '系统提示',
              message: res.data.msg || '与服务器校验数据失败',
              confirmButtonText: '重新登录',
              zIndex: 999
            }).then(() => {
              gt.loginAction();
            });

        }
      },
      fail(res) {

      }
    });
  },

  /**
   * 获取记录在本地的登录验证Token
   */
  getLoginToken() {
    var token = wx.getStorageSync('login_token')
    return token;
  },

  /**
   * 获取小程序订阅消息模板ID
   */
  getTemplateList(callback) {
    this.ajaxSubmit({
      url: '/?g=API&m=Index&a=getTemplateID',
      success: function (res) {
        if (res.data.status == 200) {
          callback(res.data.data)
        }
      }
    })
  },


})