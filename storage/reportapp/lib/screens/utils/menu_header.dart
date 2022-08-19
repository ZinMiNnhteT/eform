import 'package:flutter/material.dart';

class MenuHeader extends StatelessWidget {

  final String logo;
  final String slogam;
  final String appName; 
  final Map links;

  MenuHeader({this.logo, this.slogam, this.appName, this.links});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: EdgeInsets.symmetric(horizontal:30.0, vertical: 50.0),
      child: Row(
        children: <Widget>[
          Image.asset(
            logo,
            width: 50.0,
            height: 50.0,
          ),
          SizedBox(width: 10.0,),
          Column(
            mainAxisAlignment: MainAxisAlignment.center,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: <Widget>[
              Text(
                appName,
                style: TextStyle(
                  color: Colors.yellowAccent,
                  fontSize: 20.0,
                ),
              ),
              SizedBox(height: 8.0,),
              Text(
                slogam,
                style: TextStyle(
                  color: Colors.white,
                  fontSize: 15.0,
                ),
              ),
            ],
          ),
        ],
      ),
      decoration: BoxDecoration(
        color: Colors.lightBlue,
        borderRadius: BorderRadius.only(bottomRight: Radius.circular(30.0)),
        boxShadow: [
          BoxShadow(
            color: Colors.grey,
            blurRadius: 5.0, // soften the shadow
            spreadRadius: 1, //extend the shadow
            offset: Offset(
              -5.0, // Move to right 10  horizontally
              2.0, // Move to bottom 10 Vertically
            ),
          )
        ],
      ),
    );
  }
}