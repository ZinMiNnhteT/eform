import 'package:flutter/material.dart';
import 'package:reportapp/screens/account/account.dart';
import 'package:reportapp/screens/account/leave_request.dart';
import 'package:reportapp/screens/auth/login.dart';
import 'package:reportapp/screens/office_management/my_signature_pad.dart';
import 'package:reportapp/screens/office_management/service_item_form.dart';
import 'package:reportapp/screens/office_management/service_report_detail.dart';
import 'package:reportapp/screens/office_management/service_report_form.dart';
import 'package:reportapp/screens/template/home.dart';
import 'package:reportapp/screens/office_management/office_management.dart';
import 'package:reportapp/screens/office_management/service_report_list.dart';
import 'package:reportapp/screens/office_management/quotation_list.dart';
import 'package:reportapp/screens/office_management/quotaion_form.dart';

void main() => runApp(MyApp());

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      initialRoute: '/',
      routes: {
        '/': (context) => Login(),
        // '/home': (context) => Home(),
        // '/home': (context) => OfficeManagement(),
        '/office_management': (context) => OfficeManagement(),
        '/service_report':(context) => ServiceReportList(),
        '/service_report_form':(context) => ServiceReportForm(),
        '/service_report_detail':(context) => ServiceReportDetail(),
        '/quotation_list':(context) => QuotationList(),
        '/quotation_form':(context) => QuotationForm(),
        '/account':(context) => Account(),
        '/leave_request': (context) => LeaveRequest(),
        '/my_signature_pad': (context) => MySignaturePad(),
        '/service_item_form': (context) => ServiceItemForm(),
      },
      debugShowCheckedModeBanner: false,
      title: 'ReportApp',
      theme: ThemeData(
        primarySwatch: Colors.lightBlue,
        // fontFamily: 'Raleway',
      ),
    );
  }
}