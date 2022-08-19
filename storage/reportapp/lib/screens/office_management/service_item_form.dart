import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:http/http.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:connectivity/connectivity.dart';

class ServiceItemForm extends StatefulWidget {
  @override
  _ServiceItemFormState createState() => _ServiceItemFormState();
}

class _ServiceItemFormState extends State<ServiceItemForm> {

  final logo = Hero(
    tag: 'hero',
    child: Image.asset(
      'assets/images/nexthop-logo.png',
      width: 100.0,
      height: 100.0,
    )
  );

  String connectionState; bool serverError = false;

  var _formKey = GlobalKey<FormState>();

  SharedPreferences sharedPreferences;

  Map data = {}; String reportId;

  TextEditingController serviceDescriptionController = TextEditingController();
  TextEditingController chargeAmountController = TextEditingController();
  bool charge = false;
  double chargeAmount;

  String selectedService = 'Select Services';
  List<String> serviceList = [];

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

  Widget appBar(BuildContext context){
    return AppBar(
      leading: IconButton(
        icon: Icon(Icons.close, color: Colors.white,),
        onPressed: (){
          backToDetail();
        },
      ),
      title: Row(
        children: <Widget>[
          Expanded(
            flex: 8,
            child: Center(
              child: Text('Add Service Item    ',style: TextStyle(color: Colors.white,fontSize: 16.0,),),
            ),
          ),
          Expanded(
            flex: 1,
            child: IconButton(
              icon: Icon(Icons.check, color: Colors.white,),
              onPressed: (){
                if(_formKey.currentState.validate()){
                  saveForm();
                }
              },
            ),
          ),
        ],
      ),
    );
  } 

  TextFormField itemDescriptionField(){
    return TextFormField(
      controller: serviceDescriptionController,
      decoration: InputDecoration(
        hintText: "Service Description", 
        hintStyle: TextStyle(fontSize: 13.0),
        border: OutlineInputBorder(),
        contentPadding: EdgeInsets.all(10.0),
      ),
      maxLines: 5,
      style: TextStyle(fontSize: 14.0),
      validator: (String value){
        if(value == null || value.isEmpty){
          return 'Please enter service description';
        }
      },
    );
  }

  DropdownButtonHideUnderline serviceDropdown() {
    print('service list is');
    print(serviceList);
    return DropdownButtonHideUnderline(
      child: Container(
        padding: EdgeInsets.symmetric(horizontal: 10.0),
        decoration: ShapeDecoration(
          shape: OutlineInputBorder(
            borderSide: BorderSide(color: Colors.grey),
            borderRadius: BorderRadius.circular(5.0),
          ),
        ),
        child: DropdownButton<String>(
          value: this.selectedService,
          isExpanded: true,
          items: serviceList.map((String service){
            return DropdownMenuItem(
              value: service,
              child: Text(service, style: TextStyle(fontSize: 13.0),),
            );
          }).toList(),
          onChanged: (String selected){
            // print(selected);
            setState(() {
              this.selectedService = selected;
            });
            if(selected != 'Select Services'){
              setState(() {
                serviceDescriptionController.text = selected;
              });
            }
          },
        ),
      ),
    );
  }

  CheckboxListTile chargeCheckBox(){
    return CheckboxListTile(
      title: const Text('Charged', style: TextStyle(color: Colors.black54),),
      value: charge,
      onChanged: (bool value) {
        setState(() { 
          charge = value;
        });
        if(!this.charge){
          chargeAmountController.clear();
        }
      },
      dense: true,
      controlAffinity: ListTileControlAffinity.leading,
    );
  }

  TextFormField chargeAmountField(){
    return TextFormField(
      keyboardType: TextInputType.number,
      controller: chargeAmountController,
      decoration: InputDecoration(
        hintText: "Charge Amount", 
        hintStyle: TextStyle(fontSize: 13.0),
        border: OutlineInputBorder(),
        contentPadding: EdgeInsets.all(15.0),
        filled: !charge,
        fillColor: Colors.grey[200],
      ),
      style: TextStyle(fontSize: 14.0),
      enabled: charge,
      validator: (String value){
        if(_isNotNumeric(value) && charge){
          return 'Please enter valid number';
        }
      },
    );
  }

  bool _isNotNumeric(String str) {
    if(str == null) {
      return true;
    }
    return double.tryParse(str) == null;
  }

  void saveForm(){
    // saving data
    saveDataToServer(); 

    backToDetail();
    clearForm();
    _showAlertDialog('Success', 'You have added service item!');
  }

  void saveDataToServer() async{

    connectionCheck();

    Map<String,String> bodyData = {
      'reportId'    : this.reportId,
      'serviceName' : serviceDescriptionController.text,
      'chargeAmount': chargeAmountController.text,
    };

    print('body data is');
    print(bodyData);
    sharedPreferences = await SharedPreferences.getInstance();
    String apiLink = sharedPreferences.getString('apiLink');
    Response response = await post( apiLink + 'flutter_api/service_report/add_service_item',body:bodyData); 
    print('response if adding service item');
    
    print(jsonDecode(response.body));
  }

  void clearForm(){
    setState(() {

    });
  }

  void backToDetail() {
    Navigator.pop(context, true);
  }

  void _showAlertDialog(String title, String content){
    showDialog(
      context: context,
      builder: (context){
        return AlertDialog(
          title: Text(title, style: TextStyle(fontSize: 16.0),),
          content: Text(content, style: TextStyle(fontSize: 14.0),),
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

  Widget body(BuildContext context){
    return Form(
      key: _formKey,
      child: Container(
        margin: EdgeInsets.all(10.0),
        child: ListView(
          children: <Widget>[
            itemDescriptionField(),
            SizedBox(height: 10.0,),
            serviceDropdown(),
            SizedBox(height: 10.0,),
            chargeCheckBox(),
            SizedBox(height: 10.0,),
            chargeAmountField(),
          ],
        ),
      ),
    );
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
      ),
    );
  }

  @override
  Widget build(BuildContext context) {

    // getting carried data
    data = data.isNotEmpty ? data : ModalRoute.of(context).settings.arguments;
    
    print('carry data from detail is');
    print(data);

    if(this.reportId == null){
      setState(() {
        this.reportId = data['reportId'];
        this.serviceList = data['serviceList'];
      });
    }
    
    return Scaffold(
      appBar: appBar(context),
      body: this.connectionState == 'offline' ? noInternetConnection() : (this.serverError ? serverErrorOccur() : body(context)),
    );
  }
}