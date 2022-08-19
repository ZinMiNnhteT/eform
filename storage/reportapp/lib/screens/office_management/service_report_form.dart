import 'package:flutter/material.dart';
import 'package:http/http.dart';
import 'package:intl/intl.dart';
import 'package:reportapp/models/company.dart';
import 'package:reportapp/models/customer.dart';
import 'package:datetime_picker_formfield/datetime_picker_formfield.dart';
import 'package:reportapp/models/service_report.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert';

final _serviceReportForm = GlobalKey<FormState>();

TextEditingController itemOriController = TextEditingController();
TextEditingController amountOriController = TextEditingController();

class ServiceReportForm extends StatefulWidget {
  @override
  _ServiceReportFormState createState() => _ServiceReportFormState();
}

class _ServiceReportFormState extends State<ServiceReportForm> {
  SharedPreferences sharedPreferences;
  bool isLoading = false;

  Map data = {};
  ServiceReport serviceReport;
  String reportId = '0';

  String selectedCompanyId;
  String selectedCurrency;
  String currencyErrorText = '';
  String appTitle = 'Add Service Report';

  TextEditingController dateController = TextEditingController();
  TextEditingController contactPersonController = TextEditingController();
  TextEditingController contactPhoneController = TextEditingController();
  TextEditingController errorRemarkController = TextEditingController();
  TextEditingController startTimeController = TextEditingController();
  TextEditingController endTimeController = TextEditingController();

  TextStyle errorStyle = TextStyle(color: Colors.red[300], fontSize: 11.0);
  TextStyle inputTextStyle = TextStyle(fontSize: 14.0);

  List<Company> companyList = List<Company>();

  @override
  void initState() {
    super.initState();
    gettingFormData();
  }

  void gettingFormData() async {
    sharedPreferences = await SharedPreferences.getInstance();
    if (sharedPreferences.getBool('loginState') != true) {
      Navigator.pushNamedAndRemoveUntil(
          context, '/', (Route<dynamic> route) => false);
    } else {
      try {
        String apiLink = sharedPreferences.getString('apiLink');
        Response response =
            await get(apiLink + "flutter_api/service_report/get_companies?");
        print('response of getting companies is');
        print(response.body);
        List<dynamic> lists = jsonDecode(response.body);
        int countList = lists.length;
        for (int i = 0; i < countList; i++) {
          setState(() {
            companyList.add(Company.mapToObject(lists[i]));
          });
        }
        print('company list is');
        print(companyList);
        setState(() {
          isLoading = false;
        });
      } catch (e) {
        setState(() {
          isLoading = false;
        });
        _showAlertDialog('Sorry!',
            'Something went wrong in getting data. It may be a cause of server error or internet connection.');
      }
    }
  }

  void closeForm() {
    clearForm();
    Navigator.pop(context, true);
  }

  void saveForm() async {
    // Navigator.pop(context);
    setState(() {
      isLoading = true;
    });

    sharedPreferences = await SharedPreferences.getInstance();
    String apiLink = sharedPreferences.getString('apiLink');

    print('saving report');
    print(this.reportId);

    try {
      Response response =
          await post(apiLink + 'flutter_api/service_report/add_service', body: {
        'reportId': this.reportId,
        'company': selectedCompanyId,
        'contactPerson': contactPersonController.text,
        'contactTel': contactPhoneController.text,
        'errorRemark': errorRemarkController.text,
        'engineer': sharedPreferences.getString('userId'),
        'duration': startTimeController.text + ' - ' + endTimeController.text,
        'reportDate': dateController.text,
        'Currency_type': selectedCurrency,
      });
      dynamic result = jsonDecode(response.body);

      print('response data in creating new service report is');
      print(result);

      if (result['status'] == true) {
        if (result['reportId'] != null) {
          setState(() {
            this.reportId = result['reportId'].toString();
          });
          print('service report Id after inserting data');
          print(this.reportId);
          goToPreview();
        } else {
          clearForm();
          setState(() {
            isLoading = false;
          });
          Navigator.pop(context, true);
          _showAlertDialog('Success', result['message']);
        }
      } else {
        clearForm();
        setState(() {
          isLoading = false;
        });
        _showAlertDialog('Error', result['message']);
      }
    } catch (e) {
      clearForm();
      setState(() {
        isLoading = false;
      });
      print('Error in creating new service report ---- ');
      print(e.toString());
      _showAlertDialog('Error', 'Erorr occurs in creating new sevice report!');
    }
  }

  void goToPreview() {
    Navigator.pushReplacementNamed(context, '/service_report_detail',
        arguments: {'reportId': this.reportId.toString()});
  }

  void _showAlertDialog(String title, String content) {
    showDialog(
        context: context,
        builder: (context) {
          return AlertDialog(
            title: Text(
              title,
              style: TextStyle(fontSize: 16.0),
            ),
            content: Text(
              content,
              style: TextStyle(fontSize: 14.0),
            ),
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

  void clearForm() {
    setState(() {
      this.serviceReport = null;
      this.selectedCompanyId = null;
      this.dateController.clear();
      this.contactPersonController.clear();
      this.contactPhoneController.clear();
      this.errorRemarkController.clear();
      this.selectedCurrency = null;
      this.startTimeController.clear();
      this.endTimeController.clear();
    });
  }

  Widget appBar(BuildContext context) {
    return AppBar(
      leading: IconButton(
        icon: Icon(
          Icons.close,
          color: Colors.white,
        ),
        onPressed: () {
          closeForm();
        },
      ),
      title: Row(
        children: <Widget>[
          Expanded(
            flex: 8,
            child: Center(
              child: Text(
                appTitle + '    ',
                style: TextStyle(
                  color: Colors.white,
                  fontSize: 16.0,
                ),
              ),
            ),
          ),
          Expanded(
            flex: 1,
            child: IconButton(
              icon: Icon(
                Icons.check,
                color: Colors.white,
              ),
              onPressed: () {
                print('save ');
                if (_serviceReportForm.currentState.validate() &
                    checkCurrencyField()) {
                  saveForm();
                  print('save form done');
                }
              },
            ),
          ),
        ],
      ),
    );
  }

  bool checkCurrencyField() {
    if (this.selectedCurrency == null || this.selectedCurrency.isEmpty) {
      setState(() {
        this.currencyErrorText = 'PLease choose MMK or USD';
      });
      return false;
    } else {
      setState(() {
        this.currencyErrorText = null;
      });
      return true;
    }
  }

  Widget companyNameDropdown() {
    return DropdownButtonFormField<String>(
      decoration: InputDecoration(
        border: OutlineInputBorder(),
        isDense: true,
        labelText: 'Choose Company Name',
        labelStyle: TextStyle(fontSize: 14.0),
        contentPadding: EdgeInsets.all(10.0),
      ),
      items: companyList.map((Company company) {
        return DropdownMenuItem(
          value: company.companyId.toString(),
          child: Container(
            width: 250,
            child: Text(
              company.companyName,
              style: TextStyle(fontSize: 14.0),
            ),
          ),
        );
      }).toList(),
      onChanged: (String selected) {
        print(selected);
        setState(() {
          if (selected != '0') {
            selectedCompanyId = selected;
          } else {
            selectedCompanyId = null;
          }
        });
      },
      value: selectedCompanyId,
      validator: (String value) {
        if (value == null || value.isEmpty) {
          return 'Please choose company name';
        }
      },
    );
  }

  Widget newCompanyButton() {
    return FlatButton(
      child: Icon(
        Icons.add_box,
        color: Colors.blueAccent,
      ),
      onPressed: () {
        showNewCompanyFormDialog();
        // showNewCompanyFormDialog();
      },
    );
  }

  void showNewCompanyFormDialog() {
    TextEditingController companyNameController = TextEditingController();
    TextEditingController addressController = TextEditingController();
    TextEditingController phoneNoController = TextEditingController();

    showDialog<void>(
      barrierDismissible: false,
      context: context,
      builder: (BuildContext context) {
        String companyNameError = '';
        String addressError = '';
        String phoneError = '';

        print('1 companyNameError is $companyNameError');

        return StatefulBuilder(
          builder: (context, setState) {
            return AlertDialog(
              title: Text('Add Company', style: TextStyle(fontSize: 16.0)),
              content: ListView(
                shrinkWrap: true,
                children: <Widget>[
                  TextFormField(
                    controller: companyNameController,
                    decoration: InputDecoration(
                      border: OutlineInputBorder(),
                      isDense: true,
                      labelText: 'Company Name',
                      labelStyle: TextStyle(fontSize: 14.0),
                      contentPadding: EdgeInsets.all(10.0),
                    ),
                  ),
                  companyNameError.isNotEmpty ? Text(companyNameError,style: TextStyle(color: Colors.red, fontSize: 11.0),) : SizedBox(),
                  SizedBox(
                    height: 10.0,
                  ),
                  TextFormField(
                    controller: addressController,
                    maxLines: 5,
                    decoration: InputDecoration(
                      border: OutlineInputBorder(),
                      isDense: true,
                      labelText: 'Address',
                      labelStyle: TextStyle(fontSize: 14.0),
                      contentPadding: EdgeInsets.all(10.0),
                    ),
                  ),
                  addressError.isNotEmpty ? Text(addressError,style: TextStyle(color: Colors.red, fontSize: 11.0),) : SizedBox(),
                  SizedBox(
                    height: 10.0,
                  ),
                  TextFormField(
                    controller: phoneNoController,
                    decoration: InputDecoration(
                      border: OutlineInputBorder(),
                      isDense: true,
                      labelText: 'Contact Telephone',
                      labelStyle: TextStyle(fontSize: 14.0),
                      contentPadding: EdgeInsets.all(10.0),
                    ),
                  ),
                  phoneError.isNotEmpty ? Text(phoneError,style: TextStyle(color: Colors.red, fontSize: 11.0),) : SizedBox(),
                ],
              ),
              actions: <Widget>[
                FlatButton(
                  child: const Text('CANCEL'),
                  onPressed: () {
                    Navigator.of(context).pop();
                  },
                ),
                FlatButton(
                  child: const Text(
                    'SAVE',
                    style: TextStyle(color: Colors.green),
                  ),
                  onPressed: () async {
                    bool goToserver = true;
                    if (companyNameController.text.isEmpty) {
                      setState(() {
                        goToserver = false;
                        companyNameError = 'Please enter company name';
                      });
                    }
                    if (addressController.text.isEmpty) {
                      setState(() {
                        goToserver = false;
                        addressError = 'Please enter address';
                      });
                    }
                    if (phoneNoController.text.isEmpty) {
                      setState(() {
                        goToserver = false;
                        phoneError = 'Please enter contact telephone';
                      });
                    }
                    if(goToserver){
                      saveCompany(companyNameController.text,addressController.text,phoneNoController.text);
                      Navigator.of(context).pop();
                    }
                  },
                )
              ],
            );
          },
        );
      },
    );
  }

  void saveCompany(String companyName, String address, String tel) async {
    sharedPreferences = await SharedPreferences.getInstance();
      String apiLink = sharedPreferences.getString('apiLink');
      Map<String, dynamic> bodyData = {
        'companyName' : companyName,
        'address'     : address,
        'tel'         : tel,
      };
      Response response = await post(apiLink + 'flutter_api/service_report/save_company',body: bodyData);
      var responseData = jsonDecode(response.body);
      if(responseData['status']){
        var companyNew = responseData['data'];
        print('comapny New is');
        print(companyNew);
        setState(() {
          print('compny List is old');
          print(this.companyList.length);
          this.companyList.add(Company.mapToObject(companyNew));
          print('compny List is now');
          print(this.companyList.length);
          print((this.companyList[this.companyList.length-1]).companyName);
        });
      }
  }

  Widget dateFormField(BuildContext context) {
    return DateTimeField(
      controller: dateController,
      format: DateFormat('dd-MM-yyyy'),
      decoration: InputDecoration(
        border: OutlineInputBorder(),
        contentPadding: EdgeInsets.all(12.0),
        labelText: 'Choose Date',
        prefixIcon: Icon(Icons.date_range),
      ),
      style: TextStyle(fontSize: 14.0),
      onShowPicker: (context, currentValue) async {
        final date = await showDatePicker(
          context: context,
          initialDate: currentValue ?? DateTime.now(),
          firstDate: DateTime(1990),
          lastDate: DateTime(2030),
        );
        if (date == null) {
          return currentValue;
        } else {
          return date;
        }
      },
      validator: (value) {
        if (dateController.text.length < 1) {
          return "Please choose date";
        }
      },
    );
  }

  Widget contactPersonFormField(BuildContext context) {
    return TextFormField(
      controller: contactPersonController,
      decoration: InputDecoration(
          labelText: 'Contact Person',
          contentPadding: EdgeInsets.all(12.0),
          isDense: true,
          border: OutlineInputBorder()),
      style: TextStyle(fontSize: 14.0),
      validator: (String value) {
        if (value == null || value.isEmpty) {
          return 'Please enter contact person';
        }
      },
    );
  }

  Widget contactPhoneFormField(BuildContext context) {
    return TextFormField(
      keyboardType: TextInputType.number,
      controller: contactPhoneController,
      decoration: InputDecoration(
          labelText: 'Contact Telephone',
          contentPadding: EdgeInsets.all(12.0),
          isDense: true,
          border: OutlineInputBorder()),
      style: TextStyle(fontSize: 14.0),
      validator: (String value) {
        if (value == null || value.isEmpty) {
          return 'Please enter phone number';
        } else if (value != '-' && !isNumeric(value)) {
          return 'Please enter valid phone number';
        }
      },
    );
  }

  bool isNumeric(String value) {
    if (value == null) {
      return false;
    }
    return double.tryParse(value) != null;
  }

  Widget errorRemarkFormField(BuildContext context) {
    return TextFormField(
      controller: errorRemarkController,
      maxLines: 5,
      decoration: InputDecoration(
        labelText: 'Error Remarks',
        contentPadding: EdgeInsets.all(12.0),
        isDense: true,
        border: OutlineInputBorder(),
      ),
      style: TextStyle(fontSize: 14.0),
      validator: (String value) {
        if (value == null || value.isEmpty) {
          return 'Please enter error remark';
        }
      },
    );
  }

  Widget currencyFormField(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: <Widget>[
        Row(
          mainAxisAlignment: MainAxisAlignment.start,
          children: <Widget>[
            Text(
              'Currency',
              style: inputTextStyle,
            ),
            Expanded(
              child: RadioListTile(
                value: '0',
                title: Text('MMK', style: inputTextStyle),
                groupValue: selectedCurrency,
                onChanged: (String value) {
                  setState(() {
                    this.selectedCurrency = value;
                  });
                },
              ),
            ),
            Expanded(
              child: RadioListTile(
                value: '1',
                title: Text('USD', style: inputTextStyle),
                groupValue: selectedCurrency,
                onChanged: (String value) {
                  setState(() {
                    this.selectedCurrency = value;
                  });
                },
              ),
            ),
          ],
        ),
        Padding(
          padding: const EdgeInsets.only(left: 15.0),
          child: (currencyErrorText != null)
              ? Text(
                  currencyErrorText,
                  style: errorStyle,
                )
              : SizedBox(),
        ),
      ],
    );
  }

  Widget servicePeriodFormField(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: <Widget>[
        Row(
          children: <Widget>[
            Expanded(
              child: DateTimeField(
                controller: startTimeController,
                format: DateFormat.jm(),
                decoration: InputDecoration(
                  border: OutlineInputBorder(),
                  contentPadding: EdgeInsets.all(12.0),
                  labelText: 'Start Time',
                  prefixIcon: Icon(Icons.timer),
                  filled: true,
                  fillColor: Colors.green[50],
                  errorMaxLines: 2,
                ),
                style: TextStyle(fontSize: 14.0),
                onShowPicker: (context, currentValue) async {
                  final time = await showTimePicker(
                    context: context,
                    initialTime:
                        TimeOfDay.fromDateTime(currentValue ?? DateTime.now()),
                  );
                  if (time != null) {
                    return DateTimeField.convert(time);
                  } else {
                    setState(() {
                      startTimeController.text = null;
                    });
                  }
                },
                validator: (value) {
                  if (startTimeController.text == '') {
                    return "Please choose start time";
                  }
                },
              ),
            ),
            SizedBox(
              width: 10.0,
            ),
            Expanded(
              child: DateTimeField(
                controller: endTimeController,
                format: DateFormat.jm(),
                decoration: InputDecoration(
                  border: OutlineInputBorder(),
                  contentPadding: EdgeInsets.all(12.0),
                  labelText: 'End Time',
                  prefixIcon: Icon(Icons.timer),
                  filled: true,
                  fillColor: Colors.pink[50],
                  errorMaxLines: 2,
                ),
                style: TextStyle(fontSize: 14.0),
                onShowPicker: (context, currentValue) async {
                  final time = await showTimePicker(
                    context: context,
                    initialTime:
                        TimeOfDay.fromDateTime(currentValue ?? DateTime.now()),
                  );
                  if (time != null) {
                    return DateTimeField.convert(time);
                  } else {
                    setState(() {
                      endTimeController.text = null;
                    });
                  }
                },
                validator: (value) {
                  if (endTimeController.text == '') {
                    return "Please choose end time";
                  }
                },
              ),
            ),
          ],
        ),
      ],
    );
  }

  Widget body(BuildContext context) {
    if (this.serviceReport == null) {
      data = data.isNotEmpty ? data : ModalRoute.of(context).settings.arguments;
      this.serviceReport = data['serviceReport'];
      if (this.serviceReport.reportId != null) {
        String duration = serviceReport.duration;
        int dashPlace = duration.indexOf(' - ');
        String start = duration.substring(0, dashPlace);
        String end = duration.substring(dashPlace + 3);
        setState(() {
          this.appTitle = 'Edit Service Report';
          this.reportId = serviceReport.reportId;
          this.selectedCompanyId = serviceReport.company;
          this.dateController.text = serviceReport.reportDate;
          this.contactPersonController.text = serviceReport.contactPerson;
          this.contactPhoneController.text = serviceReport.contactTel;
          this.errorRemarkController.text = serviceReport.errorRemark;
          this.selectedCurrency = serviceReport.currencyType;
          this.startTimeController.text = start;
          this.endTimeController.text = end;
        });
      }
    }

    return Container(
      padding: EdgeInsets.symmetric(vertical: 20.0, horizontal: 12.0),
      child: Form(
        key: _serviceReportForm,
        child: ListView(
          children: <Widget>[
            Row(
              children: <Widget>[
                Expanded(
                  flex: 8,
                  child: companyNameDropdown(),
                ),
                Expanded(
                  flex: 1,
                  child: newCompanyButton(),
                )
              ],
            ),
            SizedBox(
              height: 20.0,
            ),
            dateFormField(context),
            SizedBox(
              height: 20.0,
            ),
            contactPersonFormField(context),
            SizedBox(
              height: 20.0,
            ),
            contactPhoneFormField(context),
            SizedBox(
              height: 20.0,
            ),
            errorRemarkFormField(context),
            SizedBox(
              height: 20.0,
            ),
            currencyFormField(context),
            SizedBox(
              height: 20.0,
            ),
            servicePeriodFormField(context),
            SizedBox(
              height: 20.0,
            ),
          ],
        ),
      ),
    );
  }

  Widget loading() {
    return Center(
      child: CircularProgressIndicator(),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: appBar(context),
      body: isLoading ? loading() : body(context),
    );
  }
}
