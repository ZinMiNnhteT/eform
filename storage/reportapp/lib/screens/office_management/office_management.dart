import 'dart:convert';

import 'package:connectivity/connectivity.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:http/http.dart';
import 'package:reportapp/screens/utils/bar_chart_sample4.dart';
import 'package:reportapp/screens/utils/office_drawer.dart';
import 'package:shared_preferences/shared_preferences.dart';

class OfficeManagement extends StatefulWidget {
  @override
  _OfficeManagementState createState() => _OfficeManagementState();
}

class _OfficeManagementState extends State<OfficeManagement> {

  bool isLoading = true;
  SharedPreferences sharedPreferences;
  String apiLink; String userId; bool serverError = false;
  String fullName = '';
  List<String> linkPermissions = [];

  String connectionState;

  var data; String scrollName = 'SERVICE REPORT';

  Color activeColor = Colors.lightBlue[50];
  Color activeShadowColor = Colors.blueGrey[300];
  Color activeTitleColor = Colors.blue;
  Color activeSubTitleColor =  Colors.grey;

  Color nonActiveColor = Colors.lightBlue[50];
  Color nonActiveShadowColor = Colors.grey[100];
  Color nonActiveTitleColor = Colors.blue;
  Color nonActiveSubTitleColor = Colors.grey;

  Color recColor;
  Color recShadowColor;
  Color recTitleColor;
  Color recSubTitleColor;

  Color invColor;
  Color invShadowColor;
  Color invTitleColor;
  Color invSubTitleColor;

  Color quoColor;
  Color quoShadowColor;
  Color quoTitleColor;
  Color quoSubTitleColor;

  Color repColor;
  Color repShadowColor;
  Color repTitleColor;
  Color repSubTitleColor;

  List<dynamic> barChartDefaultData = [{'all': 0, 'confirm': 0}, {'all': 0, 'confirm': 0}, {'all': 0, 'confirm': 0}, {'all': 0, 'confirm': 0}, {'all': 0, 'confirm': 0}, {'all': 0, 'confirm': 0}, {'all': 0, 'confirm': 0}, {'all': 0, 'confirm': 0}, {'all': 0, 'confirm': 0}, {'all': 0, 'confirm': 0}, {'all': 0, 'confirm': 0}, {'all': 0, 'confirm': 0}];

  Widget reportChart;
  Widget quotationChart;
  Widget invoiceChart;
  Widget receiptChart;
  
  var dateTime = DateTime.now();

  final logo = Hero(
    tag: 'hero',
    child: Image.asset(
      'assets/images/nexthop-logo.png',
      width: 100.0,
      height: 100.0,
    )
  );

  @override
  void initState(){
    super.initState();
    this.reportChart    = BarChartSample4(barChartDefaultData);
    this.quotationChart = BarChartSample4(barChartDefaultData);
    this.invoiceChart   = BarChartSample4(barChartDefaultData);
    this.receiptChart   = BarChartSample4(barChartDefaultData);

    getSharedPreferences();
    connectionCheck();
    getDatasFromServer();
  }

  void initializeColor(){
    setState(() {
      this.recColor = nonActiveColor;
      this.recShadowColor = nonActiveShadowColor;
      this.recTitleColor = nonActiveTitleColor;
      this.recSubTitleColor = nonActiveSubTitleColor;

      this.invColor = nonActiveColor;
      this.invShadowColor = nonActiveShadowColor;
      this.invTitleColor = nonActiveTitleColor;
      this.invSubTitleColor = nonActiveSubTitleColor;

      this.quoColor = nonActiveColor;
      this.quoShadowColor = nonActiveShadowColor;
      this.quoTitleColor = nonActiveTitleColor;
      this.quoSubTitleColor = nonActiveSubTitleColor;

      this.repColor = activeColor;
      this.repShadowColor = activeShadowColor;
      this.repTitleColor = activeTitleColor;
      this.repSubTitleColor = activeSubTitleColor;
    });
  }

  void setDefaultColor(){
    setState(() {
      this.recColor = nonActiveColor;
      this.recShadowColor = nonActiveShadowColor;
      this.recTitleColor = nonActiveTitleColor;
      this.recSubTitleColor = nonActiveSubTitleColor;

      this.invColor = nonActiveColor;
      this.invShadowColor = nonActiveShadowColor;
      this.invTitleColor = nonActiveTitleColor;
      this.invSubTitleColor = nonActiveSubTitleColor;

      this.quoColor = nonActiveColor;
      this.quoShadowColor = nonActiveShadowColor;
      this.quoTitleColor = nonActiveTitleColor;
      this.quoSubTitleColor = nonActiveSubTitleColor;

      this.repColor = nonActiveColor;
      this.repShadowColor = nonActiveShadowColor;
      this.repTitleColor = nonActiveTitleColor;
      this.repSubTitleColor = nonActiveSubTitleColor;
    });
  }

  void changeActiveColor(double pixels){
    setState(() {
      if(pixels > 519){
        this.scrollName = 'RECEIPT';
        this.recColor = activeColor;
        this.recShadowColor = activeShadowColor;
        this.recTitleColor = activeTitleColor;
        this.recSubTitleColor = activeSubTitleColor;
      }else if(pixels > 362){
        this.scrollName = 'INVOICE';
        this.invColor = activeColor;
        this.invShadowColor = activeShadowColor;
        this.invTitleColor = activeTitleColor;
        this.invSubTitleColor = activeSubTitleColor;
      }else if(pixels > 130){
        this.scrollName = 'QUOTATION';
        this.quoColor = activeColor;
        this.quoShadowColor = activeShadowColor;
        this.quoTitleColor = activeTitleColor;
        this.quoSubTitleColor = activeSubTitleColor;
      }else{
        this.scrollName = 'SERVICE REPORT';
        this.repColor = activeColor;
        this.repShadowColor = activeShadowColor;
        this.repTitleColor = activeTitleColor;
        this.repSubTitleColor = activeSubTitleColor;
      }
    });
  }

  void connectionCheck() async {
    var connectivityResult = await (Connectivity().checkConnectivity());
    if (connectivityResult == ConnectivityResult.none) {
      setState(() {
        connectionState = 'offline';
      });
    } else if (connectivityResult == ConnectivityResult.wifi) {
      setState(() {
        connectionState = 'wifi';
      });
    }else if (connectivityResult == ConnectivityResult.mobile) {
      setState(() {
        connectionState = 'mobile';
      });
    }
  }

  void getSharedPreferences() async {
    sharedPreferences = await SharedPreferences.getInstance();
    setState(() {
      apiLink = sharedPreferences.getString('apiLink');
      userId = sharedPreferences.getString('userId');
      fullName = sharedPreferences.getString('fullName');
      linkPermissions = sharedPreferences.getStringList('linkPermissions');
      linkPermissions = sharedPreferences.getStringList('linkPermissions');
    });
  }
  
  void getDatasFromServer() async {

    setState(() {
      isLoading = true;
    });

    sharedPreferences = await SharedPreferences.getInstance();
    
    setState(() {
      apiLink = sharedPreferences.getString('apiLink');
      userId = sharedPreferences.getString('userId');
      linkPermissions = sharedPreferences.getStringList('linkPermissions');
    });


    if(apiLink != null){
      try{
        String url = apiLink + '/flutter_api/office/get_data_for_dashboard?userId=' + userId;
        Response response = await get(url);
        var responseData = jsonDecode(response.body);
        print('response Data is');
        print(responseData);
        if(responseData != null){
          setState(() {
            isLoading = false;
            data = responseData;
            this.reportChart = BarChartSample4(List<dynamic>.from(data['monthlyServices']));
          });
        }
      }catch(e){
        print('error in getting dashboard data');
        print(e);
        setState(() {
          this.serverError = true;
          this.isLoading = false;
        });
      }

    }
  }

  void showAlertDialog(String title, String content){
    showDialog(
      context: context,
      builder: (BuildContext context){
        return AlertDialog(
          title: Text(title),
          content: Text(content),
          actions: <Widget>[
            FlatButton(
              child: Text('CLOSE'),
              onPressed: (){
                Navigator.of(context).pop();
              },
            )
          ],
        );
      }
    );
  }

  Widget appBar(){
    
    return AppBar(
      title: Text(
        'Dashboard',
        style: TextStyle(
          color: Colors.white,
          fontSize: 16.0,
        ),
      ),
      actions: <Widget>[
        IconButton(
          onPressed: (){
            Navigator.pushNamed(context, '/account');
          },
          icon: Icon(Icons.account_circle,color: Colors.white60,),
        ),
          
      ],
    );
  } 

  Widget quotationBox(){
    return Container(
      width: 200,
      padding: EdgeInsets.all(10.0),
      margin: EdgeInsets.all(10.0),
      decoration: BoxDecoration(
        color: quoColor,
        boxShadow: [
          BoxShadow(
            color: quoShadowColor,
            blurRadius: 5.0, // soften the shadow
            spreadRadius: 1, //extend the shadow
            
          )
        ],
        border: Border.all(color: quoColor),
        borderRadius: BorderRadius.circular(20.0),
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: <Widget>[
          Row(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: <Widget>[
              Image.asset('assets/images/quotation.png',width: 70,),
              Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: <Widget>[
                  Text('QUOTATION', style: TextStyle(fontSize: 11.0,color: quoTitleColor),),
                  SizedBox(height: 5.0,),
                  Text('...', style: TextStyle(fontSize: 30.0, fontWeight: FontWeight.bold,color: quoSubTitleColor)),
                  
                ],
              )
            ],
          ),
          Text('Comming Soon',style: TextStyle(fontSize: 10.0, fontWeight: FontWeight.bold,color: Colors.red)),
        ],
      ),
    );
  }

  Widget invoiceBox(){
    return Container(
      width: 200,
      padding: EdgeInsets.all(10.0),
      margin: EdgeInsets.all(10.0),
      decoration: BoxDecoration(
        color: invColor,
        boxShadow: [
          BoxShadow(
            color:invShadowColor,
            blurRadius: 5.0, // soften the shadow
            spreadRadius: 0.3, //extend the shadow
            
          )
        ],
        border: Border.all(color: invColor),
        borderRadius: BorderRadius.circular(20.0),
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: <Widget>[
          Row(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: <Widget>[
              Image.asset('assets/images/invoice.png',width: 80,),
              Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: <Widget>[
                  
                  Text('INVOICE', style: TextStyle(fontSize: 11.0,color: invTitleColor),),
                  SizedBox(height: 5.0,),
                  Text('...', style: TextStyle(fontSize: 30.0, fontWeight: FontWeight.bold,color: invSubTitleColor)),
                  
                ],
              )
            ],
          ),
          Text('Comming Soon',style: TextStyle(fontSize: 10.0, fontWeight: FontWeight.bold,color: Colors.red)),
        ],
      ),
    );
  }

  Widget serviceReportBox(){
    return Container(
      width: 200,
      padding: EdgeInsets.all(10.0),
      margin: EdgeInsets.all(10.0),
      decoration: BoxDecoration(
        color: repColor,
        boxShadow: [
          BoxShadow(
            color: repShadowColor,
            blurRadius: 5.0, // soften the shadow
            spreadRadius: 0.3, //extend the shadow
            
          )
        ],
        border: Border.all(color: repColor),
        borderRadius: BorderRadius.circular(20.0),
      ),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.center,
        children: <Widget>[
          Image.asset('assets/images/service_report.png',width: 80,),
          Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: <Widget>[
              
              Text('SERVICE REPORT', style: TextStyle(fontSize: 11.0,color: repTitleColor),),
              SizedBox(height: 5.0,),
              Text(
                data['yearlyServices'].toString(),
                style:TextStyle(fontSize: 30.0, fontWeight: FontWeight.bold,color: repSubTitleColor)
              ),
            ],
          )
        ],
      ),
    );
  }

  Widget receiptBox(){

    return Container(
      width: 200,
      padding: EdgeInsets.all(10.0),
      margin: EdgeInsets.all(10.0),
      decoration: BoxDecoration(
        color: recColor,
        boxShadow: [
          BoxShadow(
            color: recShadowColor,
            blurRadius: 5.0, // soften the shadow
            spreadRadius: 1, //extend the shadow
            
          )
        ],
        border: Border.all(color: recColor) ,
        borderRadius: BorderRadius.circular(20.0),
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: <Widget>[
          Row(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: <Widget>[
              Image.asset('assets/images/invoice.png',width: 70,),
              Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: <Widget>[
                  Text('   RECEIPT   ', style: TextStyle(fontSize: 11.0,color: repTitleColor,)),
                  SizedBox(height: 5.0,),
                  Text('...', style: TextStyle(fontSize: 30.0, fontWeight: FontWeight.bold,color: repSubTitleColor)),
                ],
              )
            ],
          ),
          Text('Comming Soon',style: TextStyle(fontSize: 10.0, fontWeight: FontWeight.bold,color: Colors.red)),
        ],
      ),
    );
  }

  ScrollController scrollController = ScrollController();

  Widget reportChartWidget(){
    return (this.scrollName == 'SERVICE REPORT') ? Container(
        child: Column(
          children: <Widget>[
            reportChart,
            chartTitleWidget(),
          ],
        ),
      ) : SizedBox();
  }

  Widget quotationChartWidget(){
    return (this.scrollName == 'QUOTATION') ? Container(
      child: Column(
        children: <Widget>[
          quotationChart,
          chartTitleWidget(),
        ],
      ),
    ) : SizedBox();
  }

  Widget invoiceChartWidget(){
    return (this.scrollName == 'INVOICE') ? Container(
      child: Column(
        children: <Widget>[
          invoiceChart,
          chartTitleWidget(),
        ],
      ),
    ) : SizedBox();
  }

  Widget receiptChartWidget(){
    return this.scrollName == 'RECEIPT' ? Container(
      child: Column(
        children: <Widget>[
          receiptChart,
          chartTitleWidget(),
        ],
      ),
    ) : SizedBox();
  }

  Widget chartTitleWidget(){
    return Center(
      child: Text(
        '$scrollName - ${dateTime.year.toString()}', 
        style: TextStyle(
          color:Colors.blue,
          fontWeight: FontWeight.bold
        ),
      ),
    );
  }

  Widget body(){

    return NotificationListener(
      child: data != null ? ListView(
       
        children: <Widget>[

          SizedBox(height: 30.0,),

          reportChartWidget(),

          quotationChartWidget(),

          invoiceChartWidget(),

          receiptChartWidget(),

          SizedBox(height: 20.0,),

          Container(
            child: ConstrainedBox(
              constraints: new BoxConstraints(
                minHeight: 35.0,
                maxHeight: 180.0,
              ),
              child: ListView(
                controller: scrollController,
                scrollDirection: Axis.horizontal,
                children: <Widget>[
                  serviceReportBox(),
                  quotationBox(),
                  invoiceBox(),
                  receiptBox(),
                ],
              ),
            ),
          ),

          this.userId != '1' ? Column(
            children: <Widget>[
              Container(
                decoration: BoxDecoration(
                ),
                child: ListTile(
                  leading: CircleAvatar(
                    backgroundColor: Colors.redAccent[100],
                    child: Icon(Icons.directions_run, color: Colors.white,),
                  ),
                  title: Text('Leave Request', style: TextStyle(fontSize: 14.0),),
                  subtitle: Text('Click here to request leave', style: TextStyle(fontSize: 12.0),),
                  trailing: Icon(Icons.keyboard_arrow_right),
                  onTap: () {
                    Navigator.pushNamed(context, '/leave_request');
                  },
                ),
              ),
            ],
          ) : SizedBox(),
          
        ],
      ) : SizedBox(),
      onNotification: (t) {
        if (t is ScrollEndNotification) {
          print('scroll ing ');
          print(scrollController.position.pixels);

          setDefaultColor();
          changeActiveColor(scrollController.position.pixels);
          
        }
      },
    );
  }

  Widget permissionWidget(){
    return Column(
      children: linkPermissions.map((String permission){
        return Text(permission);
      }).toList(),
    );
  }

  Widget loading(){
    return Center(
      child: CircularProgressIndicator(),
    );
  }

  Widget noInternetConnection(){
    return Container(
      margin: EdgeInsets.all(10.0),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.center,
        children: <Widget>[
          logo,
          SizedBox(height: 10.0,),
          SizedBox(height: 10.0,),
          Text("No Internet Connection",style: TextStyle(fontSize: 20.0,fontWeight: FontWeight.bold),),
          SizedBox(height: 10.0,),
          Text("Nexthop Report App requires an internet connection. Make sure that Wi-Fi or mobile data is turned on and then try again.",textAlign: TextAlign.center,),
          SizedBox(height: 20.0,),
          Material(
            borderRadius: BorderRadius.circular(30.0),
            shadowColor: Colors.redAccent.shade100,
            color: Colors.red[300],
            elevation: 5.0,
            child: MaterialButton(
              minWidth: 200.0,
              onPressed: (){
                SystemNavigator.pop();
              },
              child: Text('EXIT',style: TextStyle(color: Colors.white,fontSize: 12.0),),
            ),
          )
        ],
      ),
    );
  }

  Widget serverErrorOccur(){
    return Container(
      margin: EdgeInsets.all(10.0),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.center,
        children: <Widget>[
          logo,
          SizedBox(height: 10.0,),
          SizedBox(height: 10.0,),
          Text("Server Error",style: TextStyle(fontSize: 20.0,fontWeight: FontWeight.bold),),
          SizedBox(height: 10.0,),
          Text("The operation couldn't be completed due to server error.",textAlign: TextAlign.center,),
          SizedBox(height: 10.0,),
          Material(
            borderRadius: BorderRadius.circular(30.0),
            shadowColor: Colors.redAccent.shade100,
            color: Colors.red[300],
            elevation: 5.0,
            child: MaterialButton(
              minWidth: 200.0,
              onPressed: (){
                SystemNavigator.pop();
              },
              child: Text('EXIT',style: TextStyle(color: Colors.white,fontSize: 12.0),),
            ),
          )
        ],
      ),
    );
  }

  Widget getBody(){
    if(isLoading){
      return Scaffold(
        appBar: appBar(),
        body: loading(),
        drawer: OfficeDrawer(),
      );
    }else if(this.connectionState == 'offline'){
      return Scaffold(
        backgroundColor: Colors.white,
        body: noInternetConnection(),
      );
    }else if(this.serverError){
      return Scaffold(
        backgroundColor: Colors.white,
        body: serverErrorOccur(),
      );
    }else{
      return Scaffold(
        appBar: appBar(),
        body: body(),
        drawer: OfficeDrawer(),
      );
    }
  }

  
  @override
  Widget build(BuildContext context) {

    if(this.recSubTitleColor == null){
      initializeColor();
    }
    
    return getBody();
  }
}