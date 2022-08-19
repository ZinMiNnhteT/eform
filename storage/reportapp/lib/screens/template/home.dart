import 'package:flutter/material.dart';

class Home extends StatefulWidget {
  @override
  _HomeState createState() => _HomeState();
}

class _HomeState extends State<Home> {

  final finance = Container(
    margin: EdgeInsets.all(10.0),
    child: Flexible(
      child: FlatButton(
        onPressed: (){},
        child: Padding(
          padding: const EdgeInsets.all(20.0),
          child: Column(children: <Widget>[
            Icon(Icons.monetization_on),
            Text('Finance', style: TextStyle(color: Colors.white),),
          ],),
        ),
        color: Colors.green,
      ),
    ),
  );

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: Wrap(
          crossAxisAlignment: WrapCrossAlignment.center,
          children: <Widget>[
            finance, finance, finance,
          ],
        ),
      ),
    );
  }
}