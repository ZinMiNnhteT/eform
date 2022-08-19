import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:http/http.dart';
import 'package:reportapp/models/service_report.dart';
import 'package:reportapp/screens/utils/office_drawer.dart';
import 'package:flutter_slidable/flutter_slidable.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:connectivity/connectivity.dart';

class ServiceReportList extends StatefulWidget {
  @override
  _ServiceReportListState createState() => _ServiceReportListState();
}

enum ConfirmAction { CANCEL, ACCEPT }

class _ServiceReportListState extends State<ServiceReportList> {

  List<ServiceReport> serviceReportList = [];

  List<ServiceReport> serviceReportListForDisplay = [];
  
  bool isLoading = true;

  SharedPreferences sharedPreferences;

  List<String> linkPermissions;

  final GlobalKey<ScaffoldState> _scaffoldKey = new GlobalKey<ScaffoldState>();

  String connectionState; bool serverError = false;

  final logo = Hero(
    tag: 'hero',
    child: Image.asset(
      'assets/images/nexthop-logo.png',
      width: 100.0,
      height: 100.0,
    )
  );

  @override
  void initState() {
    super.initState();

    getServiceReport();
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

  getServiceReport() async {
    connectionCheck();
    sharedPreferences = await SharedPreferences.getInstance();
    setState(() {
      this.linkPermissions = sharedPreferences.getStringList('linkPermissions');
    });
    if(sharedPreferences.getBool('loginState') != true){
      Navigator.pushNamedAndRemoveUntil(context, '/', (Route<dynamic> route) => false);
    }else{
      try{
        // print('user id is');
        // print(sharedPreferences.getString('userId'));

        String apiLink = sharedPreferences.getString('apiLink');
        Response response = await get(apiLink + 'flutter_api/service_report/index?userId='+sharedPreferences.getString('userId'));
        print(response.body);
        print(jsonDecode(response.body));
        List<dynamic> reportList = jsonDecode(response.body);

        // print('response data is');
        // print(reportList);
        
        List<ServiceReport> result = List<ServiceReport>();
        int count = reportList.length;
        print('count is $count');
        for(int i=0; i<count; i++){
          result.add(ServiceReport.mapToObject(reportList[i]));
        }

        setState(() {
          isLoading = false;
          this.serviceReportList = result;
          this.serviceReportListForDisplay = this.serviceReportList;
        });
        
      }catch(e){
        print('Exception $e');
        setState(() {
          isLoading = false;
          serverError = true;
        });
      }
    }
  }

  TextStyle codeNoStyle = TextStyle(color: Colors.lightBlue, fontSize: 13.0,);
  TextStyle dateStyle = TextStyle(color: Colors.red, fontSize: 12.0,);
  TextStyle companyStyle = TextStyle(fontSize: 13.0,);
  TextStyle errorRemarkStyle = TextStyle(fontSize: 12.0,);

  Widget addButton(){
    if(linkPermissions.contains('office_3-report-write')){
      return IconButton(
        onPressed: (){
          goToForm(ServiceReport.emptyData());
        },
        icon: Icon(Icons.add,color: Colors.white,),
      );
    }else{
      return SizedBox();
    }
  }

  Widget appBar(BuildContext context){
    return AppBar(
      title: Text(
        'Service Report',
        style: TextStyle(
          color: Colors.white,
          fontSize: 16.0,
        ),
      ),
      actions: <Widget>[
        addButton(),
        IconButton(
          onPressed: (){
            Navigator.pushNamed(context, '/account');
          },
          icon: Icon(Icons.account_circle,color: Colors.white60,),
        ),
      ],
      
    );
  } 

  void goToForm(ServiceReport serviceReport) async {
    dynamic result = await Navigator.pushNamed(context, '/service_report_form',arguments:{
      'serviceReport' : serviceReport,
    });
    if(result == true){
      connectionCheck();
      getServiceReport();
    }
  }

  Widget search(){
    return SizedBox(
      height: 40.0,
      child: TextFormField(
        autofocus: false,
        decoration: InputDecoration(
          prefixIcon: Icon(Icons.search),
          hintStyle: TextStyle(fontSize: 13.0),
          hintText: 'Search Service Report',
          contentPadding: EdgeInsets.symmetric(vertical: 5.0, horizontal: 20.0),
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(30.0),
          ),
        ),
        style: TextStyle(
          fontSize: 14.0,
        ),
        onChanged: (value){

          setState(() {
            value = value.toLowerCase();
          });

          setState(() {
            this.serviceReportListForDisplay = serviceReportList.where((ServiceReport srobj){
              String sc = srobj.serviceCode ?? '';
              sc = sc.toLowerCase();
              
              String cn = srobj.companyName ?? '';
              cn = cn.toLowerCase();

              String em = srobj.errorRemark ?? '';
              em = em.toLowerCase();

              String d = srobj.reportDate ?? '';
              d = d.toLowerCase();

              return (
                sc.contains(value)| cn.contains(value) || em.contains(value) || d.contains(value)
              );
            }).toList();

          });
        },
      ),
    );
  }

  Widget dataList(BuildContext context){
    return ListView.builder(
      itemCount: serviceReportListForDisplay.length,
      itemBuilder: (context, index){
        return swipListItem(context,serviceReportListForDisplay[index]);
      },
    );
  }

  Widget swipListItem(BuildContext context,ServiceReport serviceReport){
    String errorRemarkString;
    if(serviceReport.errorRemark.length > 100){
      errorRemarkString = serviceReport.errorRemark.substring(0,100)+ '...';
    }else{
      errorRemarkString = serviceReport.errorRemark;
    }
    
    return Slidable(
      actionPane: SlidableDrawerActionPane(),
      actionExtentRatio: 0.25,
      child: Container(
        padding: EdgeInsets.symmetric(vertical: 5.0),
        decoration: BoxDecoration(
          border: Border(bottom: BorderSide(color: Colors.grey[300])),
        ),
        child: ListTile(
          title: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: <Widget>[
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: <Widget>[
                  Text(serviceReport.serviceCode, style: codeNoStyle,),
                  Text(serviceReport.reportDate, style: dateStyle,),
                ],
              ),
              Text(serviceReport.companyName ?? '-', style: companyStyle,),
            ],
          ),
          subtitle: Text(errorRemarkString != '' ? errorRemarkString : '-', style: errorRemarkStyle,),
          onTap: (){
            Navigator.pushNamed(context, '/service_report_detail', arguments: {
              'reportId' : serviceReport.reportId,
            });
          },
        ),
    ),
      secondaryActions: <Widget>[

        (serviceReport.signature1.length < 1 || serviceReport.signature2.length < 1) ? (
          linkPermissions.contains('office_3-report-edit') ? IconSlideAction(
            iconWidget: CircleAvatar(
              child: Icon(Icons.edit, color: Colors.orange, size: 18.0,),
              backgroundColor: Colors.grey[100],
            ),
            color: Colors.orange[100],
            foregroundColor: Colors.orange[600],
            onTap: (){
              print('go to form with data');
              print(serviceReport);
              goToForm(serviceReport);
            },
          ) : IconSlideAction(
            iconWidget: CircleAvatar(
              child: Icon(Icons.notification_important,color: Colors.amberAccent, size: 18.0,),
              backgroundColor: Colors.grey[100],
            ),
            color: Colors.amber[100],
            foregroundColor: Colors.amber[600],
            onTap: (){
              
            },
          )
        ) : IconSlideAction(
          iconWidget: CircleAvatar(
            child: Icon(Icons.check,color: Colors.green, size: 18.0,),
            backgroundColor: Colors.grey[100],
          ),
          color: Colors.green[100],
          foregroundColor: Colors.green[600],
          onTap: (){
            
          },
        ),


        (serviceReport.signature1.length < 1 || serviceReport.signature2.length < 1) ?(
          linkPermissions.contains('office_3-report-delete') ? IconSlideAction(
            color: Colors.red[100],
            iconWidget: CircleAvatar(
              child: Icon(Icons.delete, color: Colors.red, size: 18.0,),
              backgroundColor: Colors.grey[100],
            ),
            foregroundColor: Colors.red[900],
            onTap: (){
              _asyncConfirmDialog(context, serviceReport.reportId);
            },
            // onTap: () => _showSnackBar(context,'Sevice item ${serviceReport.id} is successfully deleted'),
          ) : IconSlideAction(
            color: Colors.amber[100],
            iconWidget: Text('Need to Confirm', style: TextStyle(fontSize: 12.0,color: Colors.amber[600])),
            foregroundColor: Colors.amber[600],
            onTap: (){
            },
            // onTap: () => _showSnackBar(context,'Sevice item ${serviceReport.id} is successfully deleted'),
          )
        ) : IconSlideAction(
          color: Colors.green[100],
          iconWidget: Text('Already Confirmed', style: TextStyle(fontSize: 12.0,color: Colors.white)),
          foregroundColor: Colors.green[900],
          onTap: (){
          },
          // onTap: () => _showSnackBar(context,'Sevice item ${serviceReport.id} is successfully deleted'),
        ),


      ],
    );
  }

  void _showSnackBar(BuildContext context,String message){
    final snackbar = SnackBar(content: Text(message),);
    Scaffold.of(context).showSnackBar(snackbar);
  }

  Future<ConfirmAction> _asyncConfirmDialog(BuildContext context, String reportId) async {
    return showDialog<ConfirmAction>(
      context: context,
      barrierDismissible: false, // user must tap button for close dialog!
      builder: (BuildContext context) {
        return AlertDialog(
          title: Text('Delete Service Report?', style: TextStyle(fontSize: 16.0),),
          content: const Text(
              'This action will not been taken back.'),
          actions: <Widget>[
            FlatButton(
              child: const Text('CANCEL'),
              onPressed: () {
                Navigator.of(context).pop(ConfirmAction.CANCEL);
              },
            ),
            FlatButton(
              child: const Text('DELETE', style: TextStyle(color: Colors.red),),
              onPressed: ()  {
                acceptConfirmBox(context, reportId);
              },
            )
          ],
        );
      },
    );
  }

  void acceptConfirmBox(BuildContext context, String reportId) async {
    connectionCheck();

    if(this.connectionState == 'wifi' || this.connectionState == 'mobile'){
      Navigator.of(context).pop(ConfirmAction.ACCEPT); 

      try{
        SharedPreferences sharedPreferences = await SharedPreferences.getInstance();
        String apiLink = sharedPreferences.getString('apiLink');
        Map<String, dynamic> bodyData = {
          'reportId' : reportId,
        };
        Response response = await post( apiLink + 'flutter_api/service_report/delete_service_report', body: bodyData );
        dynamic responseData = jsonDecode(response.body);
        print('response for deleting data is');
        print(responseData);
        if(responseData['status'] == true){
          setState(() {
            this.serverError = true;
            this.serviceReportList.removeWhere((sr) => sr.reportId == reportId);
          });
          _scaffoldKey.currentState.showSnackBar(
            SnackBar(
              content: Text('Successfully Deleted!'),
              duration: Duration(seconds: 3),
            )
          );
        }
      }catch(e){
        setState(() {
          this.serverError = true;
        });
      }
    }
  }

  Widget pagination(){
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: <Widget>[
        ButtonTheme(
          minWidth: 100.0,
          child: FlatButton(
            splashColor: Colors.lightBlue,
            shape: OutlineInputBorder(
              borderRadius: BorderRadius.circular(30.0),
              borderSide: BorderSide(color: Colors.grey[300]),
            ),
            child: Row(
              children: <Widget>[
                Icon(Icons.keyboard_arrow_left,color: Colors.black54),
                Text('Previous',style: TextStyle(color: Colors.black54, fontSize: 11.0),),
              ],
            ),
            onPressed: (){},
          ),
        ),
        ButtonTheme(
          minWidth: 100.0,
          child: FlatButton(
            splashColor: Colors.lightBlue,
            shape: OutlineInputBorder(
              borderRadius: BorderRadius.circular(30.0),
              borderSide: BorderSide(color: Colors.grey[300]),
            ),
            child: Row(
              children: <Widget>[
                Text('Next',style: TextStyle(color: Colors.black54, fontSize: 11.0),),
                Icon(Icons.keyboard_arrow_right,color: Colors.black54),
              ],
            ),
            onPressed: (){},
          ),
        ),
      ],
    );
  }

  Widget body(BuildContext context){
    return Container(
      child: Stack(
        children: <Widget>[
          Padding(
            padding: EdgeInsets.all(10.0),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: <Widget>[
                Container(
                  child: search(),
                ),
                SizedBox(height: 10.0,),
                Expanded(
                  child: dataList(context),
                ),
                // pagination(),
              ],
            ),
          ),
        ],
      ),
    );
  }

  void showAlertDialog(String title, String content, BuildContext context){
    showDialog(
      context: context,
      builder: (BuildContext context){
        return AlertDialog(
          title: Text(title),
          content: Text(content),
          actions: <Widget>[
            FlatButton(
              onPressed: (){
                Navigator.pop(context);
              },
              child: Text('CLOSE'),
            )
          ],
        );
      }
    );
  }

  Widget loading(){
    return Center(
      child: CircularProgressIndicator(),)
    ;
  }

  Widget noInternetConnection(){
    return Scaffold(
      backgroundColor: Colors.white,
      body: Container(
        margin: EdgeInsets.all(10.0),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          children: <Widget>[
            logo,
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

  Widget getBody(context){
    if(isLoading == true){
      return Scaffold(
        key: _scaffoldKey,
        appBar: appBar(context),
        body: loading(),
        drawer: OfficeDrawer(),
      );
    }else if(this.connectionState == 'offline'){
      return noInternetConnection();
    }else if(this.serverError){
      return Scaffold(
        backgroundColor: Colors.white,
        body: serverErrorOccur(),
      );
    }else{
      return Scaffold(
        key: _scaffoldKey,
        appBar: appBar(context),
        body: body(context),
        drawer: OfficeDrawer(),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return getBody(context);
  }
}