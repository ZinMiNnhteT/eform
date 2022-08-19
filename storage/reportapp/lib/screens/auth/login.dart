import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:http/http.dart';
import 'package:connectivity/connectivity.dart';
import 'package:reportapp/models/check_permission.dart';
import 'package:shared_preferences/shared_preferences.dart';

class Login extends StatefulWidget {
  @override
  _LoginState createState() => _LoginState();
}

class _LoginState extends State<Login> {

  SharedPreferences sharedPreferences;
  
  bool isLoading = false; String loginError = '';

  String usernametext; String password; bool noModuleState = false;

  String connectionState; bool serverError = false;

  @override
  void initState() {
    super.initState();
    connectionCheck();
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

  var _loginFormKey = GlobalKey<FormState>();

  TextEditingController usernameController = TextEditingController();
  TextEditingController passwordController = TextEditingController();

  TextStyle loginTextStyle = TextStyle(
    fontSize: 14.0,
  );

  void login(String u, String p, BuildContext context) async {
    connectionCheck();
    if(this.connectionState == 'offline'){
      setState(() {
        isLoading = false;
      });
    }else{
      try{
        sharedPreferences = await SharedPreferences.getInstance();
        setState(() {
          sharedPreferences.setString('apiLink', 'http://192.168.99.107/reportapp/'); 
        });
        Response response = await post(sharedPreferences.getString('apiLink')+'flutter_api/login',
          body:{
            'username' : u,
            'password' : p,
          }
        );
        print('logging response');
        Map data = jsonDecode(response.body);
        print(data);
        if(data['login_state']){
          setState((){
            sharedPreferences.setBool('loginState', data['login_state']);
            sharedPreferences.setString('userId', data['user_id']);
            sharedPreferences.setString('userLevel', data['user_level']);
            sharedPreferences.setString('fullName', data['full_name']);
            sharedPreferences.setString('position', data['position']);
            var modules = data['modules'];
            sharedPreferences.setStringList('modules', List<String>.from(modules));
            print('shared preferences"s modules are');
            print(sharedPreferences.getStringList('modules'));

            if(sharedPreferences.getStringList('modules').contains('Office Management')){
              goToOfficeManagement();
            }else{
              setState(() {
                this.noModuleState = true;
                isLoading = false;
              });
            }
          });
        }else{
          setState(() {
            isLoading = false;
            loginError = data['error'];
          });
        }
      }catch(e){
        print('Exception $e');
        setState(() {
          isLoading = false;
          this.serverError = true;
        });
      }
    }
  }

  void goToOfficeManagement() async {
    sharedPreferences = await SharedPreferences.getInstance();
    String apiLink = sharedPreferences.getString('apiLink');
    String userId = sharedPreferences.getString('userId');
    print('fsfdf');
    print(apiLink + 'flutter_api/office/get_link_permission?userId='+userId+'&controllerName=office_3');
    Response response = await get(apiLink+'flutter_api/office/get_link_permission?userId='+userId+'&controllerName=office_3');
    print('office management permissions are');
    print(response.body);
    var links = jsonDecode(response.body);
    sharedPreferences.setStringList('linkPermissions', List<String>.from(links));
    print('shared preferences"s linkPermissions are');
    print(sharedPreferences.getStringList('linkPermissions'));
    CheckPermission ch = CheckPermission.getRouteToGo(sharedPreferences.getStringList('linkPermissions'));
    Navigator.pushReplacementNamed(context,ch.goToLink);
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

  @override
  Widget build(BuildContext context) {
    
    final logo = Hero(
      tag: 'hero',
      child: Image.asset(
        'assets/images/nexthop-logo.png',
        width: 100.0,
        height: 100.0,
      )
    );

    final slogam = Center(
      child: Text(
        'Nexthop Report  App',
        style: TextStyle(
          color: Colors.blue,
          fontSize: 18.0,
          fontFamily: 'Righteous',
        ),
      ),
    );

    final username = TextFormField(
      controller: usernameController,
      style: loginTextStyle,
      autofocus: false,
      decoration: InputDecoration(
        hintText: 'Username',
        hintStyle: loginTextStyle,
        contentPadding: EdgeInsets.symmetric(vertical:10.0, horizontal:20.0),
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(30.0),
        ),
      ),
      validator: (String value){
        if(value.isEmpty){
          return 'Please enter username';
        }
      },
    );

    final password = TextFormField(
      controller: passwordController,
      style: loginTextStyle,
      autofocus: false,
      obscureText: true,
      decoration: InputDecoration(
        hintText: 'Password',
        hintStyle: loginTextStyle,
        contentPadding: EdgeInsets.symmetric(vertical: 10.0, horizontal: 20.0),
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(30.0),
        ),
      ),
      validator: (String value){
        if(value.isEmpty){
          return 'Please enter password';
        }
      },
    );

    final loginButton = Padding(
      padding: EdgeInsets.symmetric(vertical: 16.0),
      child: Material(
        borderRadius: BorderRadius.circular(30.0),
        shadowColor: Colors.lightBlueAccent.shade100,
        color: Colors.lightBlue,
        elevation: 5.0,
        child: MaterialButton(
          minWidth: 200.0,
          height: 42.0,
          onPressed: (){
            print('loging');
            if(_loginFormKey.currentState.validate()){
              setState(() {
                isLoading = true;
              });
              login(usernameController.text, passwordController.text, context);
            }
          },
          child: Text('Log In',style: TextStyle(color: Colors.white),),
        ),
      ),
    );

    Widget body(){
      return Container(
        decoration: BoxDecoration(
          gradient: LinearGradient(
            begin: Alignment.topRight,
            end: Alignment.bottomLeft,
            stops: [
              0.1,
              0.5,
            ],
            colors: [
              Colors.lightBlue[400],
              Colors.white,
            ]
          ),
        ),
        child: Form(
          key: _loginFormKey,
          child: Center(
            child: ListView(
              shrinkWrap: true,
              padding: EdgeInsets.only(left: 24.0, right: 24.0),
              children: <Widget>[
                logo,
                SizedBox(height: 10.0,),
                slogam,
                SizedBox(height: 48.0,),
                username,
                SizedBox(height: 10.0,),
                password,
                SizedBox(height: 5.0,),
                Text(
                  loginError, 
                  style: TextStyle(
                    fontSize: 13.0, 
                    color:Colors.red[900],
                  ),
                ),
                SizedBox(height: 5.0,),
                loginButton,
                // Text("$connectionState", style: TextStyle(fontSize: 36)),
                // Text(usernametext != null ? (this.usernametext) : 'There is no user now'),
              ],
            ),
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
          Icon(Icons.cloud_off,size: 40.0,color: Colors.blueGrey[200],),
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
              minWidth: 100.0,
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

    Widget noInternet(){
      return Container(
        padding: EdgeInsets.all(20),
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
      );
    }

    Widget noModule(){
       return Container(
        padding: EdgeInsets.all(20),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          children: <Widget>[
            logo,
            SizedBox(height: 10.0,),
            Text("Permission Denied !",style: TextStyle(fontSize: 20.0,fontWeight: FontWeight.bold),),
            SizedBox(height: 10.0,),
            Text("Your logged-in username and password are valid, but you don't have any permission to access Nexthop Report App.",textAlign: TextAlign.center,),
            SizedBox(height: 20.0,),
            
            Material(
              borderRadius: BorderRadius.circular(30.0),
              shadowColor: Colors.blueAccent.shade100,
              color: Colors.blue[300],
              elevation: 5.0,
              child: MaterialButton(
                minWidth: 300.0,
                onPressed: (){
                  Navigator.pushNamedAndRemoveUntil(context, '/', (Route<dynamic> route) => false);
                },
                child: Text('LOG IN WITH ANOTHER ACCOUNT',style: TextStyle(color: Colors.white,fontSize: 12.0),),
              ),
            ),
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
            ),
          ],
        ),
      );
    }

    Widget loading(){
      return Center(
        child: CircularProgressIndicator(),)
      ;
    }

    Widget getBody(){
      if(this.isLoading){
        return loading();
      }else if(this.connectionState == 'offline'){
        return noInternet();
      }else if(this.noModuleState){
        return noModule();
      }else if(this.serverError){
        return serverErrorOccur();
      }else{
        return body();
      }
    }

    return Scaffold(
      backgroundColor: Colors.white,
      body: getBody(),
    );
  }

  

}