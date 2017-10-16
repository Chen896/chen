/**
 * 首页看板统计、公告栏(版本信息)
 * @author Frank
 * @date 2013-9-13 15:19:263
 */

var _topContainer;                  //面板区域的顶级容器(包含了过来条件+面板)
var _controlContainer;              //放置控制台看板的容器
var _panelContainer;                //放置所有看板的容器（DIV，自己构建的）
var _reportContainer;               //放置所有报表的容器
var _taskContainer;                 //放置所有任务的容器
var _moduleCode = new Array();      //模块代码（array）
var _panelId = new Array();         //面板ID（array）
var _warehouseIdArr = new Array();  //仓库ID
var _userAccountArr = new Array();  //账户
var _warehouseId = '';              //传入后台仓库ID
var _userAccount = '';              //传入后台的账户

var _existWarehouseOption = false;  //是否存在仓库过滤条件
var _existUserAccountOption = false;//是否存在账户过滤条件
var _warehouseList = '';            //仓库数据
var _controlPanelControl;           //控制"控制台"是否显示的a标签
var _statisticsPanelControl;        //控制统计面板是否显示的a标签

var _statisticsPanelIsShow = false;
var _tagShowArr = new Array();      //存储上一次显示的选项卡，切换账户或者仓库时，选中上一次的选项卡

/**
 * 加载面板
 * @param container         放置面板数据的容器（jquery对象，div标签）
 * @param moduleCode        模块代码（array）
 * @param panelId           面板ID（array）
 * @param warehouseId       仓库ID（array）
 * @param userAccount       账户（array）
 */
function loadPanel(container,moduleCode,panelId,warehouseId,userAccount){

    //指定参数
    _topContainer = container;
    _controlContainer = $("<div>").appendTo(_topContainer);
    _controlContainer.addClass("controlContainer");
    _panelContainer = $("<div>").appendTo(_topContainer);
    _panelContainer.addClass("panel_container");
    _reportContainer = $("<div>").appendTo(_topContainer);
    _reportContainer.addClass("report_container");
    _taskContainer = $("<div>").appendTo(_topContainer);
    _taskContainer.addClass("task_container");
    _moduleCode = moduleCode;
    _panelId = panelId;
    _warehouseIdArr = warehouseId;
    _userAccountArr = userAccount;

    if(typeof(_warehouseIdArr) != 'undefined' && _warehouseIdArr.length > 0){
        _warehouseId = _warehouseIdArr[0];
        _existWarehouseOption = true;
    }
    if(typeof(_userAccountArr) != 'undefined' && _userAccountArr.length > 0){
        _userAccount = _userAccountArr[0].user_account;
        _existUserAccountOption = true;
    }

    //开启加载等待...
    _panelContainer.myLoading();
    _controlContainer.myLoading();
    //构建过来条件区域
    initFilter();

    //调用查询
    getPanelData();
    getControlData();
}

/**
 * 构建过滤条件、控制台
 */
function initFilter(){
    if(!_existUserAccountOption && !_existWarehouseOption){
        return;
    }
    //追加一个div，作为控制台Title
    var divContainerControl = $("<div>").insertBefore(_controlContainer);
    divContainerControl.addClass("table-module-title");
//  divContainerControl.css({"padding":"5px 5px","text-align":"right","clear":"both","border":"2px solid #B5D0FD"});
    divContainerControl.css({"padding":"8px 5px","text-align":"right","clear":"both"});

    var tagTitle = $("<div>").appendTo(divContainerControl);
    tagTitle.css({"width":"100px","float":"left","text-align":"left"});
    tagTitle.html("<h3>我的控制台</h3>");

    _controlPanelControl = $("<a>").appendTo(divContainerControl);
    _controlPanelControl.css("margin-right","15px");
    _controlPanelControl.html("隐藏控制台");
    _controlPanelControl.attr("href","javascript:javascript:setControlPanelShow();");
    _controlPanelControl.data("isHide",false);

    //追加一个div用来放置过滤条件控件，操作对象为看板，报表，任务
    var divContainer = $("<div>").insertBefore(_panelContainer);
    divContainer.addClass("table-module-title");
//  divContainer.css({"padding":"5px 5px","text-align":"right","clear":"both","border":"2px solid #B5D0FD"});
    divContainer.css({"padding":"5px 5px","text-align":"right","clear":"both"});

    var tagTitle = $("<div>").appendTo(divContainer);
    tagTitle.css({"width":"100px","float":"left","text-align":"left"});
    tagTitle.html("<h3>我的面板</h3>");

    _statisticsPanelControl = $("<a>").appendTo(divContainer);
    _statisticsPanelControl.css("margin-right","15px");
    _statisticsPanelControl.html("显示统计面板");
    _statisticsPanelControl.attr("href","javascript:setStatisticsPanelControl(false);");
    _statisticsPanelControl.data("isHide",false);


    //账户
    if(_existUserAccountOption){
        divContainer.append("账户：");
        var selectTag = $("<select>").appendTo(divContainer);
        selectTag.css({"width":"120px"});
        selectTag.addClass("userAccountChange");
        for ( var i = 0; i < _userAccountArr.length; i++) {
            var val = _userAccountArr[i];
            var optionTag = $("<option>").appendTo(selectTag);
            optionTag.val(val.user_account);
            optionTag.html(val.platform_user_name);
        }

        var optionTagAll = $("<option>").appendTo(selectTag);
        optionTagAll.val('all');
        optionTagAll.html('全部');
    }

    //仓库ID
    if(_existWarehouseOption){
        if(_warehouseList == ''){
            $.ajax({
                type: "post",
                dataType: "json",
                async:false,
                url: './get-warehouse-data',
                success: function (json) {
                    if(json.ask == 1){
                        _warehouseList = json.data;
                    }else{

                    }
                }
            });
        }
        var tmpWarehouseList = Array();
        var index = 0;
        for ( var k = 0; k < _warehouseIdArr.length; k++) {
            var whId = _warehouseIdArr[k];
            for ( var j = 0; j < _warehouseList.length; j++) {
                var obj = _warehouseList[j];
                if(obj.warehouse_id == whId){
                    tmpWarehouseList[index] = obj;
                    index++;
                    break;
                }
            }
        }

        var obj = tmpWarehouseList[n];
        divContainer.append("仓库：");
        var selectTag = $("<select>").appendTo(divContainer);
        selectTag.css({"width":"120px"});
        selectTag.addClass("warehouseChange");
        for ( var n = 0; n < tmpWarehouseList.length; n++) {
            var obj = tmpWarehouseList[n];
            var optionTag = $("<option>").appendTo(selectTag);
            optionTag.val(obj.warehouse_id);
            optionTag.html(obj.warehouse_code);
        }
    }

    //刷新按钮
//  var refreshTag = $("<input type='button'>").appendTo(divContainer);
//  refreshTag.val("刷新");
//  refreshTag.addClass("refreshChange baseBtn");
//  refreshTag.css("margin-left","5px");
}

/**
 * 账户切换
 */
$(".userAccountChange").live('change',function(){
    var tags = $(".chooseTag");
    var idArr = new Array();
    _tagShowArr = new Array();
    for ( var i = 0; i < tags.length; i++) {
        var element = tags[i];
        var id = $(element).attr("id");
        idArr[i] = id;
        _tagShowArr[i] = id;
    }

    _userAccount = $(this).val();
    //开启加载等待...
    _panelContainer.myLoading();
    getPanelData();

//  for ( var j = 0; j < idArr.length; j++) {
//      var tmp = idArr[j];
//      setTimeout(function(){$("#"+tmp).click();},500);
//  }
});

/**
 * 仓库切换
 */
$(".warehouseChange").live('change',function(){
    var tags = $(".chooseTag");
    var idArr = new Array();
    _tagShowArr = new Array();
    for ( var i = 0; i < tags.length; i++) {
        var element = tags[i];
        var id = $(element).attr("id");
        idArr[i] = id;
        _tagShowArr[i] = id;
    }

    _warehouseId = $(this).val();
    //开启加载等待...
    _panelContainer.myLoading();
    getPanelData();

//  for ( var j = 0; j < idArr.length; j++) {
//      var tmp = idArr[j];
//      setTimeout(function(){$("#"+tmp).click();},500);
//  }
});

/**
 * 刷新
 */
$(".refreshChange").live('click',function(){
    var tags = $(".chooseTag");
    var idArr = new Array();
    _tagShowArr = new Array();
    for ( var i = 0; i < tags.length; i++) {
        var element = tags[i];
        var id = $(element).attr("id");
        idArr[i] = id;
        _tagShowArr[i] = id;
    }

    //开启加载等待...
    _panelContainer.myLoading();
    getPanelData();
});

/**
 * 设置统计面板是否显示
 * @param isInit boolean
 */
function setStatisticsPanelControl(isInit){
    /*
     * 1. 是否有统计面板
     */
    var statisticsPanel = $(".panel_container > .panel_div");
    if(statisticsPanel.length == 0){
        _statisticsPanelControl.hide();
        return;
    }
    /*
     * 2.定义事件
     */
    var aTagControl = _statisticsPanelControl.data('isHide');
    if(isInit){
        if(_statisticsPanelIsShow){
            statisticsPanel.show();
            _statisticsPanelControl.html("隐藏统计面板");
            _statisticsPanelIsShow = true;
        }else{
            statisticsPanel.hide();
        }
    }else{
        if(aTagControl){
            statisticsPanel.hide();
            _statisticsPanelControl.html("显示统计面板");
            _statisticsPanelIsShow = false;
        }else{
            statisticsPanel.show();
            _statisticsPanelControl.html("隐藏统计面板");
            _statisticsPanelIsShow = true;
        }
        _statisticsPanelControl.data('isHide',!aTagControl);
    }
}

/**
 * 设置控制台是否显示
 * @param bol
 */
function setControlPanelShow(){
    var controlPanel = _controlContainer.find(".panel_control_div");
    if(controlPanel.length == 0){
        _controlContainer.hide();
        return;
    }

    var hide_controlPanel =  _controlContainer.find(".panel_control_div:hidden");
    if(hide_controlPanel.length > 0){
        hide_controlPanel.show();
        _controlPanelControl.html("隐藏控制台");
        return;
    }

    var visible_controlPanel =  _controlContainer.find(".panel_control_div:visible");
    if(visible_controlPanel.length > 0){
        visible_controlPanel.hide();
        _controlPanelControl.html("显示控制台");
        return;
    }
}

/**
 * 获得看板数据
 */
function getPanelData(){
    //移除所有看板
    $(".panel_div").remove();

    var params = {};
    params['osm_code'] = _moduleCode;
    params['osp_id'] = _panelId;
    params['warehouse_id'] = _warehouseId;
    params['user_account'] = _userAccount;

    $.ajax({
            type: "post",
            dataType: "json",
            data:params,
            async:true,
            url: './get-System-Board',
            success: function (json) {
                //存在数据，调用初始化方法
                if(json.ask == 1){
                    initPanel(json.data);
                    if(typeof(json.data_orderProcess) != 'undefined' && json.data_orderProcess.length > 0){
                        addOrderProcessPanel(json.data_orderProcess)
                    }
                }else{
                    notPanel();
                }

                //关闭加载图标
                _panelContainer.closeMyLoading();
            }
    });
}
/**
 * 获得控制台数据
 */
function getControlData(){
    var params = {};

    $.ajax({
            type: "post",
            dataType: "json",
            data:params,
            async:true,
            url: './get-Control-Data',
            success: function (json) {
                //存在数据，调用初始化方法
                if(json.ask == 1){
                    inintControl(json.data);
                }else{
                    //notControl();
                    alert('无控制台');
                }

                //关闭加载图标
                _controlContainer.closeMyLoading();
            }
    });
}

/**
 * 初始化面板数据
 * @param data
 */
function initPanel(jsonData){
    var bol1 = false;
    var bol2 = false;
    if(typeof(jsonData.module) != 'undefined' && jsonData.module.length > 0){
        //存在模块化面板
        $.each(jsonData.module, function (k, v) {
            addStatisticsPanel(v);
        });
        bol1 = true;
    }

    if(typeof(jsonData.unModule) != 'undefined' && jsonData.unModule.length > 0){
        //存在单独面板
        $.each(jsonData.unModule[0], function(k, v){
            //因为非模块类型，全部是单独面板，所以要拆分开,再遍历
            if(v.panel_type == '1'){
                //任务面板
                addTaskPanel(v);
            //因为非模块类型，全部是单独面板，所以要拆分开,再遍历
            }else if(v.panel_type == '2'){
                addReportPanel(v);
            }else{
                //统计面
                addStatisticsPanel(new Array(v));
            }
        });
        bol2 = true;
    }

    if(!bol1 && !bol2){
        notPanel();
    }

    //控制统计面板是否显示
    setStatisticsPanelControl(true);
}
/**
 * 初始化控制台
 * @param jsonData
 */
function inintControl(jsonData){
    if(typeof(jsonData.binding) != 'undefined' && jsonData.binding.length > 0){
        //账户绑定面板
        addBindingPanel(jsonData.binding);
    }

    if(typeof(jsonData.sales) != 'undefined' && jsonData.sales.length > 0){
        //订单销售额面板
        addSalesPanel(jsonData.sales);
    }
}

/**
 * 向指定容器追加Panel--账户绑定情况
 * @param jsonData
 */
function addBindingPanel(jsonData){
    if(!_loadTaskStyle){
        _loadTaskStyle = true;
        setTaskStyle();
    }
    /*
     * 1.构建一个DIV，用来放置任务面板
     */
    var divContainer = $("<div>").appendTo(_controlContainer);
    divContainer.addClass("panel_control_div admin_task_panel");

    /*
     * 2.设置面板的名字
     */
    var divName = $("<div>").appendTo(divContainer);
    divName.addClass("table-module-title");
    var divNameText = $("<h2>").appendTo(divName);
    divNameText.html("账户绑定");

    /*
     * 3.构建一个table，用来放绑定明细
     */
    var tableDetailContainer = $("<table>").appendTo(divContainer);
    tableDetailContainer.addClass("table-module");

    /*
     * 4. 构建tr，td用来放详情
     */
    //table中的title描述最多显示多少个(一个title对应一个val，所以是两个td标签)
    var maxTitleColspan = 2;
    var titleLength = jsonData.length;
    var titleIndex = 0;
    var trTag;
    for ( var int = 0; int < titleLength; int++) {
        if(titleIndex == 0){
            trTag = $("<tr>").appendTo(tableDetailContainer);
            trTag.addClass("manage_form_bk");
        }
        titleIndex += 1;

        if(titleIndex == maxTitleColspan){
            titleIndex = 0;
        }
        var tdTagTitle = $("<td>").appendTo(trTag);
        tdTagTitle.addClass("manage_form_bk2");
        tdTagTitle.css("text-align","center");
        tdTagTitle.html(jsonData[int].title);

        var tdTagVal = $("<td>").appendTo(trTag);

        if(jsonData[int].bol == '1'){
            var spanTag = $("<span>").appendTo(tdTagVal);
            spanTag.css({"color":"#1B9301"});
            spanTag.html(jsonData[int].title_1);
        }else{
            var aTag = $("<a>").appendTo(tdTagVal);
            aTag.attr("title","前往设置");
            aTag.attr("href","javascript:;");
            var menuClass = "sub-menu-id-" + jsonData[int].ur_id;
            var menuEvent = parent.$("." + menuClass);
            aTag.html(jsonData[int].title_0);
            aTag.attr("onclick",menuEvent.attr("onclick"));
        }
    }
}

/**
 * 向指定容器追加Panel--订单销售额
 * @param jsonData
 */
function addSalesPanel(jsonData){
    if(!_loadTaskStyle){
        _loadTaskStyle = true;
        setTaskStyle();
    }
    /*
     * 1.构建一个DIV，用来放置销售额面板
     */
    var divContainer = $("<div>").appendTo(_controlContainer);
    divContainer.addClass("panel_control_div admin_task_panel");

    /*
     * 2.设置面板的名字
     */
    var divName = $("<div>").appendTo(divContainer);
    divName.addClass("table-module-title");
    var divNameText = $("<h2>").appendTo(divName);
    divNameText.html("累计销售额");

    /*
     * 3.构建一个table，用来放销售明细
     */
    var tableDetailContainer = $("<table>").appendTo(divContainer);
    tableDetailContainer.addClass("table-module");

    /*
     * 4. 构建tr，td用来放详情
     */
    var titleLength = jsonData.length;
    var trTag;
    for ( var int = 0; int < titleLength; int++) {
        trTag = $("<tr>").appendTo(tableDetailContainer);
        trTag.addClass("manage_form_bk");

        var tdTagTitle = $("<td>").appendTo(trTag);
        //tdTagTitle.addClass("manage_form_bk2");
        var num = jsonData[int].num;
        num = "<span style='font-size:22px;color:#1B9301;;'>" + num + "</span>";
        var subtotal = jsonData[int].subtotal;
        subtotal = "<span style='font-size:22px;color:#1B9301;;' title='因汇率存在浮动，本销售数据仅供参考'>" + subtotal + "</span>";
        var title= jsonData[int].title;
        var str = $.formatStr(title ,[num,subtotal]);
        tdTagTitle.html(str);
        tdTagTitle.css("text-align","right");

    }
}

/**
 * 向指定容器追加Panel--待处理订单
 * @param jsonData
 */
function addOrderProcessPanel(jsonData){
    if(!_loadTaskStyle){
        _loadTaskStyle = true;
        setTaskStyle();
    }
    /*
     * 1.构建一个DIV，用来放置任务面板
     */
    var divContainer = $("<div>").appendTo(_taskContainer);
    divContainer.addClass("panel_div admin_task_panel");

    /*
     * 2.设置面板的名字
     */
    var divName = $("<div>").appendTo(divContainer);
    divName.addClass("table-module-title");
    var divNameText = $("<h2>").appendTo(divName);
    divNameText.html("待处理订单");

    /*
     * 3.构建两个DIV，用来放各订单状态和订单明细
     */
    var divTypeContainer = $("<div>").appendTo(divContainer);
    divTypeContainer.css({"width":"50%","float":"left"});
    var divDetailContainer = $("<div>").appendTo(divContainer);
    divDetailContainer.css({"width":"50%","float":"left"});
    var status_mark = "order_process_";
    var order_process_type_p = "order_process_type_p";
    var order_process_type_td = "order_process_type_td";

    /*
     * 4. 构建table，往里面放各状态的订单数量
     */
    var tableTypeContainer = $("<table>").appendTo(divTypeContainer);
    tableTypeContainer.addClass("table-module");
    var titleLength = jsonData.length;
    for ( var int = 0; int < titleLength; int++) {
        var trTag = $("<tr>").appendTo(tableTypeContainer);
        trTag.addClass("manage_form_bk");
        var tdTagTitle = $("<td>").appendTo(trTag);
        if(int == 0){
            tdTagTitle.addClass("manage_form_bk " + order_process_type_td);
        }else{
            tdTagTitle.addClass("manage_form_bk3 " + order_process_type_td);
        }
        tdTagTitle.css("text-align","center");
        var pTag = $("<p>").appendTo(tdTagTitle);
        pTag.addClass(order_process_type_p);
        pTag.attr("id",status_mark + int);
        pTag.css({"cursor":"pointer"});
        pTag.html(jsonData[int].title + "<span style='font-size: 22px;'>" + jsonData[int].total + "</span>");
    }

    /*
     * 4. 构建table，往里面放各状态的详细订单明细
     */
    var order_process_detail = "order_process_detail";
    for ( var int2 = 0; int2 < titleLength; int2++) {
        var tableDetailContainer = $("<table>").appendTo(divDetailContainer);
        tableDetailContainer.addClass("table-module " + order_process_detail);
        if(int2 != 0){
            tableDetailContainer.addClass("base_hide");
        }
        tableDetailContainer.addClass(status_mark + int2);
        var filter_title_Length = jsonData[int2].filter.length;
        for ( var int3 = 0; int3 < filter_title_Length; int3++) {
            var trTag = $("<tr>").appendTo(tableDetailContainer);
            trTag.addClass("manage_form_bk");
            var tdTagTitle = $("<td>").appendTo(trTag);
            tdTagTitle.addClass("manage_form_bk");
            tdTagTitle.css("text-align","center");
            var pTag = $("<p>").appendTo(tdTagTitle);
            pTag.css({"cursor":"pointer"});
            pTag.html(jsonData[int2].filter[int3].title);
            var aTag = $("<a>").appendTo(pTag);
            aTag.attr("href","javascript:;");

            var menuClass = "sub-menu-id-" + jsonData[int2].filter[int3].ur_id;
            var menuEvent = parent.$("." + menuClass);
            aTag.attr("onclick",menuEvent.attr("onclick"));
            aTag.html("<span style='font-size: 22px;'>" + jsonData[int2].filter[int3].total + "</span>");

        }
    }

    /*
     * 5. 定义事件
     */
    $("." + order_process_type_p).live("click",function(){
        //替换所有底色
        var all_td = $("." + order_process_type_td);
        all_td.each(function(){
            $(this).removeClass("manage_form_bk");
            $(this).addClass("manage_form_bk3");
        })
        //all_td.addClass("manage_form_bk2");
        $(this).parent().removeClass("manage_form_bk3");
        $(this).parent().addClass("manage_form_bk");

        var detail_class = $(this).attr("id");
        //all_td.find("." + order_process_type_td + "_" + int).addClass("manage_form_bk");

        $("." + order_process_detail).hide();
        $("." + detail_class).show();
    })
}



/**
 * 向指定容器追加Panel--报表
 * @param jsonDate
 */
function addReportPanel(jsonData){
    /*
     * 1.构建一个DIV，用来放置报表面板
     */
    var divContainer = $("<div>").appendTo(_reportContainer);
    divContainer.addClass("panel_div admin_task_panel");
    divContainer.css("width","100%");
    /*
     * 2.设置报表面板的名字
     */
    var divName = $("<div>").appendTo(divContainer);
    divName.addClass("table-module-title");
    var divNameText = $("<h2>").appendTo(divName);
    divNameText.html(jsonData.name);

    /*
     * 3.设置一个DIV来放置报表图形数据
     */
    var reportContainer = $("<div>").appendTo(divContainer);
    reportContainer.css("background","none repeat scroll 0 0 #333333");

    var reportTarget = $("<div>").appendTo(reportContainer);
    reportTarget.css("padding","5px 5px");
    var reportTargetId = "report_"+jsonData.panelId;
    reportTarget.attr("id",reportTargetId);

    /*
     * 4.获取报表所需的x，y轴所需数据
     */
    var xAxis_index;
    var yAxis_index;
    for ( var int = 0; int < jsonData.title.length; int++) {
        var array_element = jsonData.title[int];
        if(array_element.type == 'date'){
            xAxis_index = int;
        }else if(array_element.type == 'int'){
            yAxis_index = int;
        }
    }

    var xLabels = new Array();
    var yData = new Array();
    var yDataTitle = new Array();
    for ( var int2 = 0; int2 < jsonData.val.length; int2++) {
        var array_element2 = jsonData.val[int2];
        xLabels.push(array_element2[xAxis_index]);
        yData.push(array_element2[yAxis_index]);
        yDataTitle.push($.formatStr(jsonData.title[yAxis_index].text ,[array_element2[yAxis_index]]));
    }

    /*
     * 5.定义报表插件所需数据，并初始化
     */
    options = {};
    options['id'] = reportTargetId;
    options['labels'] = xLabels;
    options['data'] = yData;
    options['dataTitle'] = yDataTitle;
    var reportTargetWidth = parseInt(reportTarget.css('width'));
    options['width'] = parseInt(reportTargetWidth * 0.99);
    options['height']= 220;
    options['leftgutter'] = parseInt(reportTargetWidth * 0.01);
    options['bottomgutter'] = 20,
    options['topgutter'] = 20;
    try{
        initReport(options);
    }catch(e){
        divContainer.hide();
    }
}
/**
 * 向指定容器追加Panel--任务用
 * @param jsonData
 */
var _loadTaskStyle = false;
function addTaskPanel(jsonData){
    if(!_loadTaskStyle){
        _loadTaskStyle = true;
        setTaskStyle();
    }
    /*
     * 1.构建一个DIV，用来放置任务面板
     */
    var divContainer = $("<div>").appendTo(_taskContainer);
    divContainer.addClass("panel_div admin_task_panel");

    /*
     * 2.设置任务面板的名字
     */
    var divName = $("<div>").appendTo(divContainer);
    divName.addClass("table-module-title");
    var divNameText = $("<h2>").appendTo(divName);
    divNameText.html(jsonData.name);

    /*
     * 3.构建一个table，用来放任务明细
     */
    var tableDetailContainer = $("<table>").appendTo(divContainer);
    tableDetailContainer.addClass("table-module");

    /*
     * 4. 构建tr，td用来放详情
     */
    //table中的title描述最多显示多少个(一个title对应一个val，所以是两个td标签)
    var maxTitleColspan = 2;
    var titleLength = jsonData.title.length;
    var titleIndex = 0;
    var trTag;
    for ( var int = 0; int < titleLength; int++) {
        if(titleIndex == 0){
            trTag = $("<tr>").appendTo(tableDetailContainer);
            trTag.addClass("manage_form_bk");
        }
        titleIndex += 1;

        if(titleIndex == maxTitleColspan){
            titleIndex = 0;
        }
        var tdTagTitle = $("<td>").appendTo(trTag);
        tdTagTitle.addClass("manage_form_bk2");
        tdTagTitle.css("text-align","center");
        tdTagTitle.html(jsonData.title[int].text);

        var tdTagVal = $("<td>").appendTo(trTag);
        var aTag = $("<a>").appendTo(tdTagVal);
        aTag.attr("href","javascript:;");
        var menuClass = "sub-menu-id-" + jsonData.ur_id[0][int];
        var menuEvent = parent.$("." + menuClass);
        aTag.attr("onclick",menuEvent.attr("onclick"));
        aTag.html("<span style='font-size: 22px;'>" + jsonData.val[0][int] + "</span>");
    }

}

/**
 * 向指定容器追加Panel--统计用
 * @param jsonDataos_operating_statistics_panel
 */
function addStatisticsPanel(jsonData){
    /*
     * 1.构建一个DIV，用来放置统计面板
     */
    var divContainer = $("<div>").appendTo(_panelContainer);
    divContainer.addClass("panel_div");

    /*
     * 2.1 构建选项卡div，ul
     */
    var divTab = $("<div>").appendTo(divContainer);
    divTab.addClass("goodsTab2");
    var ulTab = $("<ul>").appendTo(divTab);

    /*
     * 2.2 循环构建选项卡li
     */
    for ( var i = 0; i < jsonData.length; i++) {
        var panelData = jsonData[i];
        var liTab = $("<li>").appendTo(ulTab);
        liTab.attr("id","tab_"+panelData.panelId);
        var liTab_className = "panel_tab_li";
        //切换账户，选中上次的选项卡（单独选项卡，直接显示)）
        if($.inArray("tab_"+panelData.panelId , _tagShowArr) != -1 || jsonData.length == 1){
            liTab_className += ' chooseTag';
        }else if(_tagShowArr.length == 0){
            liTab_className += i==0?" chooseTag":"";
        }

        liTab.addClass(liTab_className);

        var aTab =$("<a>").appendTo(liTab);
        aTab.attr("href","javascript:;");
        aTab.html(panelData.name);
    }

    /*
     * 2.3 为选项卡添加清除浮动的div
     */
    var divTabClr = $("<div>").appendTo(divTab);
    divTabClr.addClass("clr");

    /*
     * 3.1 构建面板数据
     *    a、构建一个div用来放置table
     *    b、循环构建table
     */
    var divDataBox = $("<div>").appendTo(divContainer);
    for ( var j = 0; j < jsonData.length; j++) {
        var panelData = jsonData[j];
        var tableDataBox = $("<table>").appendTo(divDataBox);
        tableDataBox.attr("cellspacing","0");
        tableDataBox.attr("cellpadding","0");
        tableDataBox.attr("border","0");
        tableDataBox.css({"margin-top": "0px","width":"100%","display":"none"});

        var className = "tab_"+panelData.panelId + " manage_form5";
        tableDataBox.addClass(className);
        //切换账户，选中上次的面板(单独面板，直接显示)
        if($.inArray("tab_"+panelData.panelId , _tagShowArr) != -1 || jsonData.length == 1){
            tableDataBox.show();
        }else if(_tagShowArr.length == 0){
            if(j == 0){
                tableDataBox.show();
            }
        }
        /*
         * 3.2 构建面板title
         */
        var tableTitle = $("<tr>").appendTo(tableDataBox);
        for ( var tmp1 = 0; tmp1 < panelData.title.length; tmp1++) {
            var title = panelData.title[tmp1].text;
            var td = $("<td>").appendTo(tableTitle);
            td.addClass("manage_form5_bk");
            td.html(title);
        }

        /*
         * 3.3 构建面板item
         */
        for ( var tmp2 = panelData.val.length -1; tmp2 > -1; tmp2--) {
            var itemArray = panelData.val[tmp2];
            var tableItem = $("<tr>").appendTo(tableDataBox);

            for ( var tmp3 = 0; tmp3 < itemArray.length; tmp3++) {
                var array_element = itemArray[tmp3];
                var td = $("<td>").appendTo(tableItem);
                td.addClass("manage_form5_bk2");
                td.html(array_element);
            }
        }
    }
}

/**
 * 绑定选项卡事件
 */
$(".panel_tab_li").live("click",function(){
    //控制选项卡的选中效果
    var parentUl = $(this).parent();
    parentUl.children("li").removeClass("chooseTag");
    $(this).addClass("chooseTag");

    //面板数据的显示和隐藏
    var tableDataClass = $(this).attr("id");
    $("." + tableDataClass).parent().children("table").hide();
    $("." + tableDataClass).show();
});

/**
 * 无面板数据，设置一个提示
 */
function notPanel(tip){
    tip = tip?tip:"无面板数据";

    var divContainer = $("<div>").appendTo(_panelContainer);
    divContainer.addClass("panel_div");
    divContainer.css({"text-align":"center","border":"1px solid #D9D9D9","height":"100px","line-height":"98px","clear":"both"});
    var tipTag = $("<h2>").appendTo(divContainer);
    tipTag.html(tip);

}

/**
 * 获得版本信息
 * @param container     放置公告的容器
 * @param code          系统代码
 */
function loadVersions(container,code) {

    var container_html = container.html();
    container.html('');

    //构建公告栏
    var taskTag = $("<div>").appendTo(container);
    taskTag.addClass("admin_task");
    $(container_html).appendTo(container);

    var titleTag = $("<div>").appendTo(taskTag);
    titleTag.addClass("table-module-title");
    titleTag.css("text-align","center");
    var titleTextTag = $("<h2>").appendTo(titleTag);
    titleTextTag.html("公告栏");

    var ulTag = $("<ul>").appendTo(taskTag);
    ulTag.addClass("versions-list-data-li");

    //设置公告栏样式
    setAnnouncementStyle();

    //请求地址,及参数
    var url="http://www.ez-wms.com/default/versions/index?callback=?";
    var data={code:code,pageSize:"8"};
    //数据展示区域
    var element = ulTag;
    element.myLoading();

    $.getJSON(url,data,function(json){
        element.closeMyLoading();
        if (isJson(json)) {
            if (json.state == '1') {
                //定义最大显示条数，追加公告
                var showMaxNum = 5;
                $.each(json.data, function (k, v) {
                    var container = $("<li>").appendTo(element);
                    var liClassName = (k >= showMaxNum)?"noneLine":"showLine";
                    container.addClass(liClassName);

                    var titleTag = $("<div>").appendTo(container);
                    titleTag.addClass("admin_task_title");
                    var titleText = $("<a>").appendTo(titleTag);
                    titleText.attr("href","javascript:;");
                    titleText.html(v.v_title);

                    var contentText = $("<p>").appendTo(titleTag);
                    contentText.hide();
                    contentText.html(v.v_content);

                    var timeText = $("<div>").appendTo(container);
                    timeText.addClass("admin_task_time");
                    timeText.html(v.v_add_time);

                });
                //是否显示更多
                if(element.find(".noneLine").length > 0){
                    var moreBt = $("<div>").appendTo(element);
                    moreBt.addClass("admin_task_more");
                    var moreBtText = $("<a>").appendTo(moreBt);
                    moreBtText.attr("href","javascript:;");
                    moreBtText.html("更多");
                    //邦定事件
                    $(".admin_task_more > a").live('click',function(){
                        var aText = element.find(".admin_task_more > a");
                        var hideLine = element.find(".noneLine:hidden");
                        if(hideLine.length > 0){
                            hideLine.show();
                            $(this).html("隐藏");
                        }else{
                            $(".versions-list-data-li").find(".noneLine:visible").hide();
                            $(this).html("更多");
                        }
                    });
                }
            }
        } else {
            var container = $("<li>").appendTo(element);
            var tmp = $("<div>").appendTo(container);
            tmp.html("暂无公告");
        }
    });

}

//公告详情
$(".admin_task_title > a").live('click',function(){
    //标题
    var title = $(this).html();
    //公告内容
    var content = $(this).next().html();
    //时间
    var time = $(this).parent().next().html();

    var width = 750;
    var height = 500;
    var html = '<div title="公告" id="dialog-auto--tip">'
                    +'<div style="text-align:center;">'
                        +'<h2>'+title+'</h2>'
                    +'</div>'
                    +'<div style="border: 1px solid #D9D9D9;padding:10px 5px;">'
                        +'<p>'+content+'</p>'
                        +'<p style="text-align: right;height: 18px;">'+time+'</p>'
                    +'</div>'
                +'</div>';

    $(html).dialog({
            autoOpen: true,
            width: width,
            maxHeight: height,
            modal: true,
            show: "slide",
            close: function () {
                $(this).detach();
            }
    });
});

/**
 * 设置公告栏样式
 */
function setAnnouncementStyle(){
    var _style = (!$("<style>"))?$("<style>").eq(0):$("<style>").insertBefore("body");
    _style.append(".admin_task { border:1px solid #d9d9d9; border-top:none; padding-bottom:4px; margin-left:12px;max-height: 410px;overflow:auto;}"+
                ".admin_task h2 { height:30px; line-height:30px; padding:0px 10px; background:url(../images/index/bg_index02.gif) repeat-x; border-bottom:1px solid #e3e3e3; font-size:12px; font-weight:bold; }"+
                ".admin_task ul {padding-bottom:20px;}"+
                ".admin_task ul li { padding-left:10px; margin:5px 10px; height:38px;border-bottom:1px solid #d9d9d9;overflow:hidden;}"+
                ".admin_task_text { width:80%; float:left; height:38px; line-height:38px;  overflow:hidden;}"+
                ".admin_task_operate { width:60px; height:38px; line-height:38px; float:right; text-align:right; color:#999; overflow:hidden; }"+
                ".admin_task_title {float: left;font-size: 12px;height: 16px;overflow: hidden;text-align: left;text-overflow: ellipsis;white-space: nowrap;width: 240px;}"+
                ".admin_task_time {float: right; font-size: 10px; height: 18px;}"+
                ".admin_task_more {float: right; height: 18px;padding-right: 10px;}"+
                ".noneLine {display: none;}");
}

/**
 * 设置任务栏样式
 */
function setTaskStyle(){
    var _style = (!$("<style>"))?$("<style>").eq(0):$("<style>").insertBefore("body");
    _style.append(".admin_task_panel{-moz-border-bottom-colors: none;-moz-border-left-colors: none;-moz-border-right-colors: none;-moz-border-top-colors: none;border-color: #D9D9D9;"+
                        "border-image: none;border-style: none solid solid;border-width: medium 1px 1px;margin-top: 6px;margin-right: 5px;margin-bottom: 5px;max-height: 410px;overflow: auto;float: left;width: 49%;}"+
                  ".admin_task_panel h2 {color:#666666;border-bottom: 1px solid #E3E3E3;font-size: 12px;font-weight: bold;height: 30px;"+
                        "line-height: 30px;padding: 0 10px;}"+
                  ".admin_task_panel table{float:left;margin-top:0px;width:100%;border:0;cellpadding:0;cellspacing:0;}");
}

/**
 * 替换字符串中的占位符
 * @param str   可能还有占位符的字符串
 * @param array 替换占位符的数组
 * @returns String
 * 调用方式：
 * var str = "表情{0}，表情{1}，表情{2}";
 * var ary = ['→ →','← ←','_(:3」∠)_'];
 * var tmp = $.formatStr(str ,ary));
 */
$.formatStr = function (){

    //传入数组为空时直接返回
    if(!arguments[1]){
        return arguments[0];
    }

    //存放替换占位符的数组
    var ary = [];
    for(i = 0 ; i < arguments[1].length ; i++){
        ary.push(arguments[1][i]);
    }

    return arguments[0].replace(/\{(\d+)\}/g,function(m ,i){
        //对于溢出的占位符，替换为空字符串
        return (ary[i])?ary[i]:"";
    });
};