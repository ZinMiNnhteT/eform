import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';

class Account extends StatefulWidget {
  @override
  _AccountState createState() => _AccountState();
}

class _AccountState extends State<Account> {

  String fullName = '';
  String userId = '';
  String userLevel = '';
  String position = '';

  SharedPreferences sharedPreferences;

  @override
  void initState() {
    super.initState();
    checkLoginStatus();
  }

  checkLoginStatus() async{
    sharedPreferences = await SharedPreferences.getInstance();
    if(sharedPreferences.getBool('loginState') != true){
      Navigator.pushNamedAndRemoveUntil(context, '/', (Route<dynamic> route) => false);
    }else{
      setState(() {
        fullName = sharedPreferences.getString('fullName') ?? '';
        userId = sharedPreferences.getString('userId') ?? '';
        userLevel = sharedPreferences.getString('userLevel') ?? '';
        position = sharedPreferences.getString('position') ?? '';
      });
    }
  }

  @override
  Widget build(BuildContext context) {

    print('buildeing');

    return Scaffold(
      body: Container(
        decoration: BoxDecoration(
          gradient: LinearGradient(
            begin: Alignment.topCenter,
            end: Alignment(0.1, 0.2),
            stops: [0.1, 0.5],
            colors: [
              Colors.lightBlue[200],
              Colors.white,
            ]
          ),
        ),
        child: ListView(
          children: <Widget>[

            Column(
              crossAxisAlignment: CrossAxisAlignment.end,
              children: <Widget>[
                Container(
                  child: IconButton(
                    icon: Icon(Icons.close),
                    onPressed: (){
                      Navigator.pop(context);
                    },
                  ),
                ),
              ],
            ),
            SizedBox(height: 10.0,),

            CircleAvatar(
              radius: 50.0,
              child: Image.asset('assets/images/admin.png'),
              backgroundColor: Colors.white,
            ),

            SizedBox(height: 20.0,),

            Center(child: Text(fullName, style: TextStyle(fontSize: 20.0),),),

            SizedBox(height: 10.0,),

            Center(child: Text(position),),

            SizedBox(height: 20.0,),

            Container(
              decoration: BoxDecoration(
                border: Border(bottom: BorderSide(color: Colors.grey[300]), top: BorderSide(color: Colors.grey[300])),
              ),
              child: ListTile(
                leading: CircleAvatar(
                  backgroundColor: Colors.lightBlueAccent,
                  child: Icon(Icons.person_outline, color: Colors.white,),
                ),
                title: Text('Personalization', style: TextStyle(fontSize: 14.0),),
                trailing: Icon(Icons.keyboard_arrow_right),
                onTap: () {
                  showAlertDialog(
                  'Hey!',
                  'Personalization is under-maintaince',
                  context);
                },
              ),
            ),
           
            Container(
              decoration: BoxDecoration(
                border: Border(bottom: BorderSide(color: Colors.grey[300])),
              ),
              child: ListTile(
                leading: CircleAvatar(
                  backgroundColor: Colors.grey[400],
                  child: Icon(Icons.power_settings_new, color: Colors.white,),
                ),
                title: Text('Log Out', style: TextStyle(fontSize: 14.0),),
                trailing: Icon(Icons.keyboard_arrow_right),
                onTap: (){
                  setState(() {
                    sharedPreferences.clear();
                    sharedPreferences.commit();
                  });
                  Navigator.pushNamedAndRemoveUntil(context, '/', (Route<dynamic> route) => false);
                },
              ),
            ),



          ],
        ),
      ),
    );
  }

  void showAlertDialog(String title, String content, BuildContext context) {
    showDialog(
        context: context,
        builder: (BuildContext context) {
          return AlertDialog(
            title: Text(title),
            content: Text(content),
            actions: <Widget>[
              FlatButton(
                onPressed: () {
                  Navigator.pop(context);
                },
                child: Text('CLOSE'),
              )
            ],
          );
        });
  }

  void navigateToLeaveForm() async {
    await Navigator.pushNamed(context, '/leave_request');
  }
}