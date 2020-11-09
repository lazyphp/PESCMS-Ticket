import Dialog from '../../miniprogram_npm/@vant/weapp/dialog/dialog';

const app = getApp()

Page({

  data: {
    tabbarActive: 0,
    stepsActive: 0,
    steps: [{
        text: '选择问题类型',
      },
      {
        text: '选择对应工单',
      },
      {
        text: '创建工单',
      }
    ],
    value: '',
    ticket: '',
    tNumber: '',
    title: '{{wxapp_title}}',
    loading: true
  },

  onSearch(event) {
    if(!event.detail){
      Dialog.alert({
        message: '请输入您要搜索的工单信息',
        zIndex: 999
      })
      return false
    }
    wx.redirectTo({
      url: '../../pages/ticket/detail?number='+event.detail
    })
  },

  /**
   * 步骤条动作
   * @param {*} event 
   */
  stepFunc(event) {

    if (this.data.stepsActive == 0 || event.detail == 2 ) {
      return false;
    }

    var id;
    switch (event.detail) {
      case 1:
        id = this.data.steps[event.detail]['id'];
        break;
      case 0:
      default:
        id = 0;
    }

    this.commonRequest(id, event.detail);

  },

  /**
   * 获取工单模型
   * @param {*} event 
   */
  getTicketList(event) {
    var id = event.currentTarget.dataset.id;

    this.setData({
      ticket: null,
      loading: true
    });
    if (!id) {
      this.setData({
        ticket: {
          msg: '获取工单号码错误'
        },
        loading: false
      });
      return false;
    }

    this.data.steps[1]['id'] = id; //将当前的ID值记录在 第二个参数的步骤条

    this.commonRequest(id, 1);

  },



  /**
   * 打开工单
   */
  openTicket(event) {
    this.setData({
      ticket: {},
      stepsActive: 2,
      tNumber: event.currentTarget.dataset.id
    });
  },

  /**
   * 页面加载时的动作
   */
  onLoad() {
    this.init();
  },

  /**
   * 小程序打开时加载的数据
   */
  init() {
    this.commonRequest(0, 0);
  },

  /**
   * 刷新数据
   */
  refresh() {
    this.setData({
      ticket: null,
      loading: true
    });
    this.commonRequest(0, 0);
  },

  /**
   * 公共请求方法
   * @param {*} id 
   * @param {*} stepsActive 
   */
  commonRequest(id, stepsActive) {
    var dom = this;
    
    this.setData({
      tNumber: ''
    })

    app.ajaxSubmit({

      url: '/?g=API&m=Index&a=index&id=' + id,
      success(res) {
        dom.setData({
          ticket: res.data,
          loading: false,
          stepsActive: stepsActive
        })
      },
      fail(res) {
        dom.setData({
          ticket: {
            status: 0,
            msg: res.errMsg
          },
          loading: false
        })
      }

    });


  }



})