import 'dart:convert';
import 'dart:io';
import 'dart:typed_data';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:http/http.dart';
import 'package:reportapp/models/get_signature.dart';
import 'package:reportapp/models/service_report.dart';
import 'package:reportapp/models/service_report_item.dart';
import 'package:path_provider/path_provider.dart';

import 'package:pdf/pdf.dart';
import 'package:pdf/widgets.dart' as pdf;
import 'package:printing/printing.dart';
import 'package:shared_preferences/shared_preferences.dart';

import 'package:connectivity/connectivity.dart';


class ServiceReportDetail extends StatefulWidget {
  @override
  _ServiceReportDetailState createState() => _ServiceReportDetailState();
}

class _ServiceReportDetailState extends State<ServiceReportDetail> {

  String connectionState; bool serverError = false;

  final logo = Hero(
    tag: 'hero',
    child: Image.asset(
      'assets/images/nexthop-logo.png',
      width: 100.0,
      height: 100.0,
    )
  );

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

  SharedPreferences sharedPreferences;

 

  Map data = {};
  ServiceReport serviceReport;
  String reportId,
      companyName,
      date,
      address,
      codeNo,
      contactPerson,
      serviceDuration,
      errorRemark;
  List<int> pdfFileData;

  List<ServiceReportItem> itemList = List<ServiceReportItem>();
  bool isLoading = true;

  // for signature pad
  ByteData engineerSign = ByteData(0);
  ByteData receiverSign = ByteData(0);

  String engineerName; String engineerSignImg= ''; String receiverName; String receiverSignImg = ''; String engineerSignImgInFolder = '';

  var signatureBase64img;
  String apiLink = ''; List<String> linkPermissions = [];

  List<ServiceReportItem> relatedServices = List<ServiceReportItem>();
  List<String> serviceList = ['Select Services'];

  var color = Colors.red;
  var strokeWidth = 5.0;

  TextEditingController engineerNameController = TextEditingController();
  TextEditingController receiverNameController = TextEditingController();

  List<DataRow> itemRows = [];

  TextStyle tableHeaderStyle = TextStyle(
    fontSize: 12.0,
    color: Colors.black45,
  );

  TextStyle tableBodyStyle = TextStyle(
    fontSize: 12.0,
    color: Colors.black54,
  );

  TextStyle tableFooterStyle = TextStyle(
    fontSize: 12.0,
    color: Colors.black,
  );

  @override
  void initState(){
    super.initState();
    initializeData();
  }

  void initializeData() async {
    connectionCheck();

    sharedPreferences = await SharedPreferences.getInstance();
    linkPermissions = sharedPreferences.getStringList('linkPermissions');
    String userId = sharedPreferences.getString('userId');
    
    GetSignature gs = GetSignature.getSign(userId);

    if(gs.img != null){
      setState(() {
        if(this.engineerSignImg.length < 1){
          this.engineerSignImg = 'system_img/' + gs.img;
        }
      });
    }
  }
    
      Widget appBar(BuildContext context) {
        return AppBar(
          leading: IconButton(
            icon: Icon(
              Icons.close,
              color: Colors.white,
            ),
            onPressed: () {
              goToList();
            },
          ),
          title: Row(
            children: <Widget>[
              Expanded(
                flex: 8,
                child: Center(
                  child: Text(
                    ' Service Report Preview       ',
                    style: TextStyle(
                      color: Colors.white,
                      fontSize: 16.0,
                    ),
                  ),
                ),
              ),
              Expanded(
                flex: 1,
                child: (engineerSignImg.length > 0 && receiverSignImg.length > 0) ? IconButton(
                  icon: Icon(
                    Icons.print,
                    color: Colors.white,
                  ),
                  onPressed: () async{
    
                    connectionCheck();
    
                    sharedPreferences = await SharedPreferences.getInstance();
    
                    String apiLink = sharedPreferences.getString('apiLink');
                    print('geting print');
    
                    print(apiLink + 'flutter_api/service_report/print_report?reportId=' + this.reportId);
    
                    try{
    
                      Response response = await get(apiLink + 'flutter_api/service_report/print_report?reportId=' + this.reportId);
    
                      dynamic responseData = jsonDecode(response.body);
    
                      print(responseData);
    
                      if(responseData['status'] == true){
    
                        var fileData = await get(apiLink + 'service_report_pdf/'+this.codeNo+'.pdf');
    
                        var fileByte = fileData.bodyBytes;
    
                        if(fileByte != null){
    
                          setState(() {
                            this.pdfFileData = fileByte;
                          });
    
                          if(this.pdfFileData!= null){
    
                            print('printing occurs');
    
                            Printing.layoutPdf(
                              onLayout: buildPdf,
                            ).then((response) async {
                              connectionCheck();
                              try{
                                Response r = await get(apiLink + 'flutter_api/service_report/delete_print_report_file?file=' + this.codeNo + '.pdf');
                                dynamic rd = jsonDecode(r.body);
                                print('printing delete result is');
                                print(rd);
                              }catch(e){
                                setState(() {
                                  this.serverError = true;
                                });
                              }
                            });
                          }
    
                          }
    
                        // print('printing rsponse is');
                        // print(response);
    
                        // if(response == true){
                          
                        // }
                        
                      }
                    }catch(e){
                      setState(() {
                        this.serverError = true;
                      });
                    }
                  },
                ) : SizedBox(),
              ),
            ],
          ),
        );
      }
    
      void goToList() {
        Navigator.pushReplacementNamed(context, '/service_report');
      }
    
      List<int> buildPdf(PdfPageFormat format){
        return this.pdfFileData;
        // final doc = pdf.Document();
    
        // doc.addPage(
        //   pdf.Page(
        //     pageFormat: PdfPageFormat.a4,
        //     build: (pdf.Context context) {
        //       return pdf.ConstrainedBox(
        //         constraints: const pdf.BoxConstraints.expand(),
        //         child: pdf.FittedBox(
        //           child: pdf.Text(
        //             'HI',
        //           ),
        //         ),
        //       );
        //     },
        //   ),
        // );
        // print('doc save is');
        // print(doc.save);
        // return doc.save();
      }
    
      readFile() async {
        SharedPreferences sharedPreferences = await SharedPreferences.getInstance();
        String apiLink = sharedPreferences.getString('apiLink');
        String desiredDestinationPath = apiLink + 'service_report_pdf/' + this.codeNo + '.pdf';
        print('destination path is' + desiredDestinationPath);
        
    
        var data = await get(desiredDestinationPath);
    
        var bytes = data.bodyBytes;
    
        print('bytes are');
        print(bytes);
    
        return bytes;
    
        
      }
    
      Widget serviceDescription() {
        return Card(
          margin: EdgeInsets.fromLTRB(10.0, 10.0, 10.0, 5.0),
          elevation: 0.0,
          shape: Border.all(color: Colors.white),
          child: Column(
            children: <Widget>[
              Row(
                crossAxisAlignment: CrossAxisAlignment.center,
                children: <Widget>[
                  Expanded(
                    child: ListTile(
                      title: Text(
                        'Company Name',
                        style: TextStyle(fontSize: 12.0),
                      ),
                      subtitle: Text(
                        this.companyName,
                        style: TextStyle(fontSize: 13.0),
                      ),
                    ),
                  ),
                  Expanded(
                    child: ListTile(
                      title: Text(
                        'Date',
                        style: TextStyle(fontSize: 12.0),
                      ),
                      subtitle: Text(
                        this.date,
                        style: TextStyle(fontSize: 13.0),
                      ),
                    ),
                  ),
                ],
              ),
              Row(
                children: <Widget>[
                  Expanded(
                    child: ListTile(
                      title: Text(
                        'Address',
                        style: TextStyle(fontSize: 12.0),
                      ),
                      subtitle: Text(
                        this.address,
                        style: TextStyle(fontSize: 13.0),
                      ),
                    ),
                  ),
                  Expanded(
                    child: ListTile(
                      title: Text(
                        'Code No',
                        style: TextStyle(fontSize: 12.0),
                      ),
                      subtitle: Text(
                        this.codeNo,
                        style: TextStyle(fontSize: 13.0),
                      ),
                    ),
                  ),
                ],
              ),
              Row(
                children: <Widget>[
                  Expanded(
                    child: ListTile(
                      title: Text(
                        'Contact Person',
                        style: TextStyle(fontSize: 12.0),
                      ),
                      subtitle: Text(
                        this.contactPerson,
                        style: TextStyle(fontSize: 13.0),
                      ),
                    ),
                  ),
                  Expanded(
                    child: ListTile(
                      title: Text(
                        'Service Duration',
                        style: TextStyle(fontSize: 12.0),
                      ),
                      subtitle: Text(
                        this.serviceDuration,
                        style: TextStyle(fontSize: 13.0),
                      ),
                    ),
                  ),
                ],
              ),
            ],
          ),
        );
      }
    
      Widget errorRemarkWidget() {
        return Card(
          margin: EdgeInsets.symmetric(vertical: 5.0, horizontal: 10.0),
          elevation: 0.0,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(0.0)),
          child: ListTile(
            contentPadding: EdgeInsets.symmetric(horizontal: 10.0),
            title: Text(
              'Error Remark',
              style: TextStyle(fontSize: 12.0),
            ),
            subtitle: Text(
              this.errorRemark,
              style: TextStyle(fontSize: 13.0),
            ),
          ),
        );
      }
    
      Widget addNewItemWidget(BuildContext context) {
        return linkPermissions.contains('office_3-report-write') ? (engineerSignImg.length < 1 || receiverSignImg.length < 1) ? Container(
          margin: EdgeInsets.symmetric(horizontal: 10.0),
          child: FlatButton.icon(
            color: Colors.green[300],
            icon: Icon(
              Icons.add,
              color: Colors.white,
            ),
            label: Text(
              'Add Item',
              style: TextStyle(color: Colors.white),
            ),
            onPressed: () {
              goToItemForm();
            },
          ),
        ) : SizedBox() : SizedBox();
      }
    
      void goToItemForm() async {
        dynamic result = await Navigator.pushNamed(context, '/service_item_form',
            arguments: {
              'reportId': this.reportId,
              'serviceList': this.serviceList
            });
        if (result) {
          getServiceReportDataFromServer(this.reportId);
        }
      }
    
      void setItemRows() {
        int itemCount = 0;
        double chargeAmount = 0.0;
    
        List<DataRow> rows = itemList.map((ServiceReportItem item) {
    
          setState(() {
            itemCount = itemCount + 1;
            if (int.tryParse(item.chargeAmount) > 0) {
              chargeAmount += int.tryParse(item.chargeAmount);
            }
          });
    
          return DataRow(cells: [
            DataCell(Text(
              itemCount.toString(),
              textAlign: TextAlign.right,
              style: tableBodyStyle,
            )),
            DataCell(Text(
              item.serviceName,
              style: tableBodyStyle,
            )),
            DataCell(
              Align(
                alignment: Alignment.center,
                child: (int.tryParse(item.chargeAmount) > 0)
                  ? Text(
                      item.chargeAmount,
                      style: tableBodyStyle,
                    )
                  : Text(
                      '-',
                      style: tableBodyStyle,
                    )
                ),
              ),
            DataCell(Align(
                alignment: Alignment.center,
                child: !(int.tryParse(item.chargeAmount) > 0)
                    ? Icon(Icons.check_box)
                    : Text(
                        '-',
                        style: tableBodyStyle,
                      ))),
            DataCell(Align(
                alignment: Alignment.center,
                child: (engineerSignImg.length < 1 || receiverSignImg.length < 1) ? IconButton(
                  onPressed: () {
                    deleteItem(item, itemCount);
                  },
                  icon: Icon(
                    Icons.cancel,
                    color: Colors.red[900],
                  ),
                ) : Text('-'))),
          ]);
        }).toList();
    
        rows.add(
          DataRow(cells: [
            DataCell(Text('')),
            DataCell(Text(
              'Total Amount',
              style: tableFooterStyle,
            )),
            DataCell(Text(
              chargeAmount.toString(),
              style: tableFooterStyle,
            )),
            DataCell(Text('')),
            DataCell(Text('')),
          ]),
        );
    
        setState(() {
          this.itemRows = rows;
        });
      }
    
      Widget itemWidget() {
        setItemRows();
    
        return Card(
          color: Colors.white,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(0.0)),
          elevation: 0.0,
          margin: EdgeInsets.symmetric(vertical: 5.0, horizontal: 10.0),
          child: SingleChildScrollView(
            scrollDirection: Axis.horizontal,
            child: DataTable(
              columnSpacing: 10,
              columns: [
                DataColumn(
                  label: Text(
                    'No.',
                    style: tableHeaderStyle,
                  ),
                ),
                DataColumn(
                    label: Text(
                  'Service Description',
                  style: tableHeaderStyle,
                )),
                DataColumn(
                    label: Text(
                  'Chargable',
                  style: tableHeaderStyle,
                )),
                DataColumn(
                    label: Text(
                  'Non Charge',
                  style: tableHeaderStyle,
                )),
                DataColumn(
                  label: (engineerSignImg.length < 1 || receiverSignImg.length < 1) ? Text(
                  'Delete',
                  style: tableHeaderStyle,
                ) : Text('-')),
              ],
              rows: this.itemRows,
            ),
          ),
        );
      }
    
      void deleteItem(ServiceReportItem item, int itemCount) async {
        connectionCheck();
        sharedPreferences = await SharedPreferences.getInstance();
        String apiLink = sharedPreferences.getString('apiLink');
        Map<String, dynamic> bodyData = {'serviceId': item.serviceId};
    
        try{
          Response response = await post(apiLink + 'flutter_api/service_report/delete_service_item',body: bodyData);
          print('ddd');
          print(apiLink + 'flutter_api/delete_service_item');
          print(bodyData);
          print(response.body);
    
          dynamic responseData = jsonDecode(response.body);
    
          // print(responseData);
    
          if (responseData['status']) {
            setState(() {
              itemList.removeWhere((data) => data.serviceId == item.serviceId);
            });
          }
        }catch(e){
          setState(() {
            this.serverError = true;
          });
        }
    
        
      }
    
      Widget signatureWidget() {
        return Row(
          children: <Widget>[
            SizedBox(
              width: 10.0,
            ),
            Expanded(
              child: engineerSignImg != ''
                  ? Container(
                      color: Colors.white,
                      child: Column(
                        children: <Widget>[
                          Image.network(engineerSignImg),
                          Text(
                            engineerName,
                            style: TextStyle(fontSize: 13.0),
                          ),
                          Padding(
                            padding: const EdgeInsets.only(top: 5, bottom: 20.0),
                            child: Text(
                              '(engineer)',
                              style:
                                  TextStyle(fontSize: 12.0, color: Colors.black45),
                            ),
                          ),
                        ],
                      ))
                  : SizedBox(),
            ),
            SizedBox(
              width: 10.0,
            ),
            Expanded(
              child: receiverSignImg != ''
                  ? Container(
                      color: Colors.white,
                      child: Column(
                        children: <Widget>[
                          Image.network(receiverSignImg),
                          Text(
                            receiverName ?? '',
                            style: TextStyle(fontSize: 13.0),
                          ),
                          Padding(
                            padding: const EdgeInsets.only(top: 5, bottom: 20.0),
                            child: Text(
                              '(Receiver)',
                              style:
                                  TextStyle(fontSize: 12.0, color: Colors.black45),
                            ),
                          ),
                        ],
                      ))
                  : SizedBox(),
            ),
            SizedBox(
              width: 10.0,
            ),
          ],
        );
      }
    
      Widget signatureLinkWidget() {
        return linkPermissions.contains('office_3-report-write') ? (((itemList.length > 0) && (engineerSignImg.length < 1 || receiverSignImg.length < 1)) ? Row(
          children: <Widget>[
            SizedBox(
              width: 10.0,
            ),
            Expanded(
              child: RaisedButton(
                onPressed: () async {
                  dynamic responseData = await Navigator.pushNamed(
                      context, '/my_signature_pad',
                      arguments: {'type': 'engineer', 'name': engineerName});
                  setState(() {
                    if (responseData['img'] != null) {
                      print('engineer sign is');
                      engineerSign = responseData['img'];
                      print(engineerSign);
                    }
                    if (responseData['name'] != null) {
                      engineerName = responseData['name'];
                    }
                  });
                  if (engineerSign.buffer.lengthInBytes != 0) {
                    List<int> engineerSignByte = engineerSign.buffer.asUint8List();
                    setState(() {
                      isLoading = true;
                      this.signatureBase64img = base64.encode(engineerSignByte);
                    });
                    saveSignatureToServer('engineer');
                  }
                },
                color: Colors.lightBlueAccent[100],
                child: Container(
                  padding: EdgeInsets.all(10.0),
                  child: Row(
                    children: <Widget>[
                      Expanded(
                        flex: 1,
                        child: Image.asset(
                          'assets/images/fountain-pen.png',
                          width: 30.0,
                          height: 30.0,
                        ),
                      ),
                      Expanded(
                        flex: 3,
                        child: Text(
                          'Engineer Signature',
                          style: TextStyle(
                            color: Colors.white,
                          ),
                          textAlign: TextAlign.center,
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ),
            SizedBox(
              width: 10.0,
            ),
            Expanded(
              child: RaisedButton(
                onPressed: () async {
                  dynamic responseData = await Navigator.pushNamed(
                      context, '/my_signature_pad',
                      arguments: {'type': 'receiver', 'name': receiverName});
                  print('the result is $responseData');
                  setState(() {
                    if (responseData['img'] != null) {
                      print('receiver sign is');
                      receiverSign = responseData['img'];
                      print(receiverSign);
                    }
                    if (responseData['name'] != null) {
                      receiverName = responseData['name'];
                    }
                  });
                  if (receiverSign.buffer.lengthInBytes != 0) {
                    List<int> receiverSignByte = receiverSign.buffer.asUint8List();
                    setState(() {
                      isLoading = true;
                      this.signatureBase64img = base64.encode(receiverSignByte);
                      print('now base 64 is');
                      print(this.signatureBase64img);
                    });
                    saveSignatureToServer('receiver');
                  }
                },
                color: Colors.orange[200],
                child: Container(
                  padding: EdgeInsets.all(10.0),
                  child: Row(
                    children: <Widget>[
                      Expanded(
                        flex: 1,
                        child: Image.asset(
                          'assets/images/fountain-pen.png',
                          width: 30.0,
                          height: 30.0,
                        ),
                      ),
                      SizedBox(
                        width: 10.0,
                      ),
                      Expanded(
                        flex: 3,
                        child: Text(
                          'Receiver Signature',
                          style: TextStyle(color: Colors.white),
                          textAlign: TextAlign.center,
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ),
            SizedBox(
              width: 10.0,
            ),
          ],
        ) : SizedBox()) : SizedBox();
      }
    
      void saveSignatureToServer(String type) async {
        connectionCheck();
    
        try{
          sharedPreferences = await SharedPreferences.getInstance();
          String apiLink = sharedPreferences.getString('apiLink');
          Map<String, dynamic> bodyData = {
            'type': type,
            'signature': this.signatureBase64img,
            'reportId': this.reportId,
            'name': receiverName,
          };
          Response response = await post(
              apiLink + 'flutter_api/service_report/save_signature',
              body: bodyData);
    
          print('response data in saving signature to server');
          print(response.body);
    
          // setState(() {
          //   this.isLoading = false;
          // });
    
          getServiceReportDataFromServer(this.reportId);
    
        }catch(e){
          setState(() {
            this.serverError = true;
          });
        }
      }
    
      Widget body() {
        return Scaffold(
            appBar: appBar(context),
            body: Container(
            decoration: BoxDecoration(
              color: Colors.grey[200],
            ),
            child: ListView(
              children: <Widget>[
                serviceDescription(),
                errorRemarkWidget(),
                (engineerSignImg.length < 1 || receiverSignImg.length < 1) ? SizedBox(
                  height: 5.0,
                ) : SizedBox(),
                addNewItemWidget(context),
                itemWidget(),
                SizedBox(
                  height: 5.0,
                ),
                signatureLinkWidget(),
                (engineerSignImg.length < 1 || receiverSignImg.length < 1) ? SizedBox(
                  height: 13.0,
                ) : SizedBox(),
                signatureWidget(),
                // SizedBox(height: 10.0,),
                // nameLinkWidget(),
                SizedBox(
                  height: 10.0,
                ),
              ],
            ),
          ),
        );
      }
    
      void getServiceReportDataFromServer(String reportId) async {
        connectionCheck();
    
        setState(() {
          this.itemList = [];
          this.serviceList = ['Select Services'];
        });
    
        try {
          sharedPreferences = await SharedPreferences.getInstance();
          String apiLink = sharedPreferences.getString('apiLink');
          Response response = await get(apiLink +
              'flutter_api/service_report/get_report_data?reportId=' +
              reportId);
          dynamic responseData = jsonDecode(response.body);
    
          print('response data is');
          print(responseData);
    
          setState(() {
            this.companyName = responseData['companyName'] ?? '-';
            this.date = responseData['date'] ?? '-';
            this.address = responseData['address'] ?? '-';
            this.codeNo = responseData['codeNo'] ?? '-';
            this.contactPerson = responseData['contactPerson'] ?? '-';
            this.serviceDuration = responseData['serviceDuration'] ?? '-';
            this.errorRemark = responseData['errorRemark'] ?? '-';
            this.engineerName = responseData['engineerName'] ?? '-';
            this.engineerNameController.text = this.engineerName;
            if (responseData['engineerSignImg'] != '') {
              this.engineerSignImg = apiLink + responseData['engineerSignImg'];
            } else {
              this.engineerSignImg = '';
            }
            this.receiverName = responseData['receiverName'] ?? '-';
            this.receiverNameController.text = this.receiverName;
            if (responseData['receiverSignImg'] != '') {
              this.receiverSignImg = apiLink + responseData['receiverSignImg'];
            } else {
              this.receiverSignImg = '';
            }
          });
    
          List<dynamic> relatedServiceList = responseData['relatedServices'];
          print('item list is ');
          print(relatedServiceList);
          print(relatedServiceList.length);
          // List<ServiceReportItem> itemList = List<ServiceReportItem>();
          int countList = relatedServiceList.length;
          for (int i = 0; i < countList; i++) {
            setState(() {
              itemList.add(ServiceReportItem.mapToObject(relatedServiceList[i]));
            });
          }
          print('now itemLList');
          print(itemList.length);
    
          List<dynamic> services = responseData['services'];
          int countServices = services.length;
          for (int i = 0; i < countServices; i++) {
            setState(() {
              serviceList.add(services[i]);
            });
          }
          print('now serviceList is');
          print(serviceList);
    
          setState(() {
            isLoading = false;
          });
        } catch (e) {
          print('Exception $e');
          setState(() {
            isLoading = false;
            this.serverError = true;
            // showAlertDialog(
            //     'Sorry!',
            //     'Something went wrong in getting data. It may be a cause of server error or internet connection.',
            //     context);
          });
        }
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
    
      Widget loading() {
        return Scaffold(
          appBar: appBar(context),
          body: Center(
            child: CircularProgressIndicator(),
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
    
      Widget getBody(context){
        if(isLoading == true){
          return  loading();
        }else if(this.connectionState == 'offline'){
          return noInternetConnection();
        }else if(this.serverError){
          return serverErrorOccur();
        }else{
          return body();
        }
      }
    
    
      @override
      Widget build(BuildContext context) {
        // getting carried data
        data = data.isNotEmpty ? data : ModalRoute.of(context).settings.arguments;
    
        print('report id is');
        print(data['reportId']);
    
        if (this.companyName == null) {
          //getting service report's detailed data from server
          getServiceReportDataFromServer(data['reportId']);
    
          setState(() {
            this.reportId = data['reportId'];
          });
        }
    
    
        return getBody(context);
      }
}
