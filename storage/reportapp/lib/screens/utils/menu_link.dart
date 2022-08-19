import 'package:flutter/material.dart';

class MenuLink extends StatelessWidget {

  final IconData icon;
  final String text;
  final Function onTap;

  MenuLink({this.onTap, this.icon, this.text});

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: EdgeInsets.symmetric(horizontal: 8.0),
      child: Container(
        // decoration: BoxDecoration(
        //   border: Border(bottom: BorderSide(color: Colors.grey[300])),
        // ),
        child: InkWell(
          splashColor: Colors.lightBlueAccent,
          onTap: onTap,
          child: Container(
            height: 50.0,
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: <Widget>[
                Row(
                  children: <Widget>[
                    Icon(
                      icon,
                      color: Colors.black38,
                    ),
                    Padding(
                      padding: EdgeInsets.all(8.0),
                      child: Text(text),
                    ),

                  ],
                ),
                Icon(
                  Icons.arrow_right,
                  color: Colors.black45,
                )
              ],
            ),
          ),

        ),
      ),
    );
  }
}