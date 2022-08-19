import 'package:flutter/material.dart';
import 'package:reportapp/screens/utils/menu_header.dart';
import 'package:reportapp/screens/utils/menu_link.dart';
import 'package:shared_preferences/shared_preferences.dart';

class OfficeDrawer extends StatefulWidget {
  @override
  _OfficeDrawerState createState() => _OfficeDrawerState();
}

class _OfficeDrawerState extends State<OfficeDrawer> {

  SharedPreferences sharedPreferences;
  String fullName = '';
  List<String> linkPermissions = [];

  @override
  void initState(){
    super.initState();
    getSharedPreferences();
  }

  void getSharedPreferences() async {
    sharedPreferences = await SharedPreferences.getInstance();
    setState(() {
      this.fullName = sharedPreferences.getString('fullName');
      this.linkPermissions = sharedPreferences.getStringList('linkPermissions');
    });
  }

  Widget officeLink(){
    if(linkPermissions.contains('office_3-index-read')){
      return MenuLink(
        icon: Icons.dashboard,
        text: 'Dashboard',
        onTap: (){
          Navigator.pushReplacementNamed(context, '/office_management');
        },
      );
    }else{
      return SizedBox();
    }
  }

  Widget reportLink(){
    if(linkPermissions.contains('office_3-index-read')){
      return MenuLink(
        icon: Icons.insert_drive_file,
        text: 'Service Report',
        onTap: (){
          Navigator.pushReplacementNamed(context, '/service_report');
        },
      );
    }else{
      return SizedBox();
    }
  }

  Widget quotationLink(){
    if(linkPermissions.contains('office_3-index-read')){
      return MenuLink(
        icon: Icons.insert_drive_file,
        text: 'Quotation',
        onTap: (){
          Navigator.pushReplacementNamed(context, '/quotation_list');
        },
      );
    }else{
      return SizedBox();
    }
  }

  Widget links(){
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.only(topRight: Radius.circular(30.0)),
        // boxShadow: [
        //   BoxShadow(
        //     color: Colors.grey[300],
        //     blurRadius: 2.0, // soften the shadow
        //     spreadRadius: 1.0, //extend the shadow
        //     offset: Offset(
        //       -5.0, // Move to right 10  horizontally
        //       -2.0, // Move to bottom 10 Vertically
        //     ),//extend the shadow
        //   )
        // ],
      ),
      child: ListView(
        children: <Widget>[

          officeLink(),
          reportLink(),
          
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Drawer(
      child: Container(
        color: Colors.grey[200],
        child: Stack(
          children: <Widget>[
            Column(
              children: <Widget>[
                
                
                MenuHeader(
                  logo: 'assets/images/nexthop-logo.png',
                  slogam: 'Office Management',
                  appName: 'Report App',
                ),

                FlatButton(
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: <Widget>[
                      Text('LOGGED IN AS',style:TextStyle(color: Colors.grey, fontSize: 13.0)),
                      SizedBox(width: 10.0,),
                      Text(this.fullName,style:TextStyle(color: Colors.blue, fontSize: 13.0)),
                    ],
                  ),
                  onPressed: (){
                    // Navigator.pushNamed(context, '/account');
                  },
                ),
                
                Expanded(
                  child: links(),
                ),
                
              ],
            ),
          ],
        ),
      ),
    );
  }
}