import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_signature_pad/flutter_signature_pad.dart';
import 'dart:ui' as ui;
import 'dart:typed_data';
import 'dart:math'; // for random 
import 'dart:convert';// for base64
// import 'package:flutter_material_color_picker/flutter_material_color_picker.dart';


class MySignaturePad extends StatefulWidget {
  @override
  _MySignaturePadState createState() => _MySignaturePadState();
}

class _MySignaturePadState extends State<MySignaturePad> {


  ByteData _img = ByteData(0);
  ByteData _blurImg = ByteData(0);

  var color = Colors.black;
  var strokeWidth = 5.0;

  final _sign = GlobalKey<SignatureState>();

  Map dataArgs = {};
  String type; String appTitle = ''; bool editName = true;

  final _formKey = GlobalKey<FormState>();
  TextEditingController nameController = TextEditingController();

  bool signDo = false; String errorSign;




  Widget appBar(BuildContext context){
    return AppBar(
      leading: IconButton(
        icon: Icon(Icons.arrow_back, color: Colors.white,),
        onPressed: () {
          Map<String, dynamic> responseData = {
            'name' : null,
            'img' : null
          };
          Navigator.pop(context,responseData);
        },
      ),
      title: Text(appTitle,style: TextStyle(color: Colors.white,fontSize: 16.0,),),
      // actions: [
      //   Builder(
      //     builder: (context) => IconButton(
      //           icon:Icon(Icons.settings, color: Colors.white,),
      //           onPressed: () => Scaffold.of(context).openEndDrawer(),
      //           tooltip: MaterialLocalizations.of(context).openAppDrawerTooltip,
      //         ),
      //   ),
      // ],
    );
  } 

  @override
  Widget build(BuildContext context) {

    dataArgs = dataArgs.isNotEmpty ? dataArgs : ModalRoute.of(context).settings.arguments;

    print(dataArgs);

    if(this.type == null){
      setState(() {
        this.type = dataArgs['type'];
        nameController.text = dataArgs['name'];
        if(this.type == 'engineer'){
          this.appTitle = 'Engineer Signature';
          this.editName = false;
        }else{
          this.appTitle = 'Receiver Signature';
          this.editName = true;
        }
      });
    }

    return Scaffold(
      resizeToAvoidBottomPadding: false,
      appBar: appBar(context),
      body: Form(
        key: _formKey,
        child: Column(
          children: <Widget>[
            Container(
              margin:const EdgeInsets.all(10.0),
              padding: const EdgeInsets.all(8.0),
              child: TextFormField(
                style: TextStyle(fontSize: 14.0),
                decoration: InputDecoration(
                  border: OutlineInputBorder(),
                  isDense: true,
                  labelText: 'Name',
                  labelStyle: TextStyle(fontSize: 14.0),
                  contentPadding: EdgeInsets.all(10.0),
                  fillColor: editName ?  Colors.white : Colors.grey[300],
                  filled: true,
                ),
                enabled: editName,
                controller: nameController,
                validator: (value){
                  if(value.isEmpty || value == ''){
                    return 'Please enter name';
                  }
                },
              ),
            ),
            Container(
              width: 300,
              height: 300,
              margin: EdgeInsets.only(left:20.0, bottom: 20.0, right:20.0 ),
              child: Padding(
                padding: const EdgeInsets.all(8.0),
                child: Signature(
                  color: color,
                  key: _sign,
                  onSign: () {
                    final sign = _sign.currentState;
                    setState(() {
                      signDo = true;
                    });
                    debugPrint('${sign.points.length} points in the signature');
                  },
                  // backgroundPainter: _WatermarkPaint("2.0", "2.0"),
                  strokeWidth: strokeWidth,
                ),
              ),
              color: Colors.black12,
            ),
            Container(
              margin: EdgeInsets.only(bottom: 20.0),
              child: Text(errorSign ?? '', style: TextStyle(color: Colors.red, fontSize: 11.0),)),
            Column(
              children: <Widget>[
                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    MaterialButton(
                      color: Colors.lightBlueAccent,
                      onPressed: () async {
                        if(_formKey.currentState.validate()){
                          final sign = _sign.currentState;
                          final image = await sign.getData();
                          var data = await image.toByteData(format: ui.ImageByteFormat.png);

                          setState(() {
                            sign.clear();
                            _img = data;
                          });
                          
                          final encoded = base64.encode(data.buffer.asUint8List());
                          debugPrint("onPressed " + encoded);
                          Map<String, dynamic> responseData = {
                            'name' : nameController.text,
                            'img' : _img
                          };

                          print('Response data in signature pad is');
                          print(responseData);

                          if(signDo){
                            Navigator.pop(context,responseData);
                          }else{
                            setState(() {
                              this.errorSign = 'Please sign';
                            });
                          }
                          
                        }
                      },
                      child: Text("Save", style: TextStyle(color: Colors.white)),
                    ),
                    SizedBox(width: 10.0,),
                    MaterialButton(
                      color: Colors.grey,
                      onPressed: () {
                        final sign = _sign.currentState;
                        sign.clear();
                        setState(() {
                          _img = ByteData(0);
                          signDo = false;
                        });
                        debugPrint("cleared");
                        // Navigator.pop(context,_img);
                      },
                      child: Text("Clear", style: TextStyle(color: Colors.white))
                    ),
                  ],
                ),
                false ? Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: <Widget>[
                    MaterialButton(
                      onPressed: () {
                        setState(() {
                          color = color == Colors.green ? Colors.red : Colors.green;
                        });
                        debugPrint("change color");
                      },
                      child: Text("Change color")
                    ),
                    MaterialButton(
                      onPressed: () {
                        setState(() {
                          int min = 1;
                          int max = 10;
                          int selection = min + (Random().nextInt(max - min));
                          strokeWidth = selection.roundToDouble();
                          debugPrint("change stroke width to $selection");
                        });
                      },
                      child: Text("Change stroke width")
                    ),
                  ],
                ) : SizedBox(),
              ],
            )
          ],
        ),
      ),
      // endDrawer: SignatureSettingDrawer(),
    );
  }
}

class SignatureSettingDrawer extends StatefulWidget {
  @override
  _SignatureSettingDrawerState createState() => _SignatureSettingDrawerState();
}

class _SignatureSettingDrawerState extends State<SignatureSettingDrawer> {
  @override
  Widget build(BuildContext context) {
    return Drawer(
      // Add a ListView to the drawer. This ensures the user can scroll
      // through the options in the drawer if there isn't enough vertical
      // space to fit everything.
      child: ListView(
        // Important: Remove any padding from the ListView.
        padding: EdgeInsets.zero,
        children: <Widget>[
          Container(
            height: 90.0,
            child: DrawerHeader(
              child: Text('Signature Settings'),
              decoration: BoxDecoration(
                color: Colors.blue,
              ),
            ),
          ),
          
          
          ListTile(
            title: Text('Color'),
            onTap: () async {
              
              // Update the state of the app.
              // ...
              // Navigator.pop(context);
            },
            
          ),
        ],
      ),
    );
  }
}

class _WatermarkPaint extends CustomPainter {
  final String price;
  final String watermark;

  _WatermarkPaint(this.price, this.watermark);

  @override
  void paint(ui.Canvas canvas, ui.Size size) {
    canvas.drawCircle(Offset(size.width / 2, size.height / 2), 10.8, Paint()..color = Colors.blue);
  }

  @override
  bool shouldRepaint(_WatermarkPaint oldDelegate) {
    return oldDelegate != this;
  }

  @override
  bool operator ==(Object other) =>
      identical(this, other) || other is _WatermarkPaint && runtimeType == other.runtimeType && price == other.price && watermark == other.watermark;

  @override
  int get hashCode => price.hashCode ^ watermark.hashCode;
}