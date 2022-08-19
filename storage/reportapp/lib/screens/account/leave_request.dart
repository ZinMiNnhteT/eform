import 'package:datetime_picker_formfield/datetime_picker_formfield.dart';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import 'package:reportapp/models/type_of_leave.dart';

class LeaveRequest extends StatefulWidget {
  @override
  _LeaveRequestState createState() => _LeaveRequestState();
}

class _LeaveRequestState extends State<LeaveRequest> with SingleTickerProviderStateMixin {

  var _fullDayFormKey = GlobalKey<FormState>();
  var _halfDayFormKey = GlobalKey<FormState>();

  List<TypeOfLeave> _typeOfLeaveList = [
    TypeOfLeave(id: 1, name: 'Annual Leave'),
    TypeOfLeave(id: 2, name: 'Casual Leave'),
    TypeOfLeave(id: 3, name: 'Medical Leave'),
    TypeOfLeave(id: 4, name: 'Unpaid Leave'),
  ];

  final List<Tab> myTabs = <Tab>[
    Tab(text: 'Full Day'),
    Tab(text: 'Half Day'),
  ];

  TabController _tabController;
  TextEditingController fullEmployeeController = TextEditingController();
  TextEditingController startDateController = TextEditingController();
  TextEditingController endDateController = TextEditingController();
  TextEditingController descriptionController = TextEditingController();
  String selectedTypeOfLeave;

  TextEditingController dateController = TextEditingController();
  TextEditingController descriptionController2 = TextEditingController();
  String _selectedTime;
  String _selectedTimeError;
  String selectedTypeOfLeave2;

  TextStyle inputTextStyle = TextStyle(
    fontSize: 14.0,
  );

  TextStyle errorStyle = TextStyle(
    fontSize: 12.0,
    color: Colors.red[600]
  );

  @override
  void initState() {
    super.initState();
    _tabController = TabController(vsync: this, length: myTabs.length);
  }

  @override
  void dispose() {
    _tabController.dispose();
    super.dispose();
  }

  Widget appBar(){
    return AppBar(
      leading: IconButton(
        icon: Icon(Icons.close, color: Colors.white,),
        onPressed: (){
          Navigator.pop(context);
        },
      ),
      title: Row(
        children: <Widget>[
          Expanded(
            flex: 9,
            child: Center(child: Text('Leave Request   ', style: TextStyle(fontSize: 16.0, color: Colors.white),))),
          Expanded(
            flex: 1,
            child: IconButton(
              icon: Icon(Icons.check, color:Colors.white),
              onPressed: (){
                if(_tabController.index == 0){
                  if(_fullDayFormKey.currentState.validate()){
                    navigateToBack();
                  }
                }else{
                  if(_halfDayFormKey.currentState.validate() & selectedTimeErrorCheck()){
                    navigateToBack();
                  }
                }
              },
            ),
          )
        ],
      ),
      bottom: TabBar(
        controller: _tabController,
        indicatorColor: Colors.white,
        labelColor: Colors.white,
        tabs: myTabs,
      ),
    );
  }

  void navigateToBack() async {
    moveToLastScreen();
    _showAlertDialog('Success', 'You have successfully requested leave!');
  }

  moveToLastScreen(){
    Navigator.pop(context);
  }

  void _showAlertDialog(String title, String content){
    showDialog(
      context: context,
      builder: (context){
        return AlertDialog(
          title: Text(title, style: TextStyle(fontSize: 16.0),),
          content: Text(content, style: TextStyle(fontSize: 14.0),),
          actions: <Widget>[
            FlatButton(
              child: Text('CLOSE'),
              onPressed: (){
                Navigator.of(context).pop();
              },
            )
          ],
        );
      }
    );
  }

  Widget employeeInputField(){
    return TextFormField(
      initialValue: 'System',
      decoration: InputDecoration(
        labelText: 'Employee Name',
        labelStyle: inputTextStyle,
        border: OutlineInputBorder(),
        contentPadding: EdgeInsets.all(12.0),
        filled: true,
        fillColor: Colors.grey[200],
      ),
      enabled: false,
      style: inputTextStyle,
    );
  }

  Widget startDateInput(){
    return DateTimeField(
      format: DateFormat('dd-MM-yyyy'),
      controller: startDateController,
      onShowPicker: (context, currentValue) async {
        final date = await showDatePicker(
          context: context,
          initialDate: currentValue ?? DateTime.now(),
          firstDate: DateTime(2000),
          lastDate: DateTime(2050),
        );
        if(date == null){
          return currentValue;
        }else{
          return date;
        }
        // return date ?? currentValue;
      },
      decoration: InputDecoration(
        border: OutlineInputBorder(),
        contentPadding: EdgeInsets.all(12.0),
        labelText: 'Start Date',
        labelStyle: inputTextStyle,
        errorMaxLines: 2,
      ),
      style: inputTextStyle,
      validator: (value){
        if(value == null){
          return 'Please choose start date';
        }
      },
    );
  }

  Widget endDateInput(){
    return DateTimeField(
      format: DateFormat('dd-MM-yyyy'),
      controller: endDateController,
      onShowPicker: (context, currentValue) async {
        final date = await showDatePicker(
          context: context,
          initialDate: currentValue ?? DateTime.now(),
          firstDate: DateTime(2000),
          lastDate: DateTime(2050),
        );
        return date ?? currentValue;
      },
      decoration: InputDecoration(
        border: OutlineInputBorder(),
        contentPadding: EdgeInsets.all(12.0),
        labelText: 'End Date',
        labelStyle: inputTextStyle,
        errorMaxLines: 2,
      ),
      style: inputTextStyle,
      validator: (value){
        if(value == null){
          return 'Please choose end date';
        }
      },
    );
  }

  Widget datePeriod(){
    return Column(
      children: <Widget>[
        Row(
          children: <Widget>[
            Expanded(
              child: startDateInput(),
            ),
            SizedBox(width: 12.0,),
            Expanded(
              child: endDateInput(),
            ),
          ],
        )
      ],
    );
  }

  Widget typeOfLeaveInput(){
    return DropdownButtonFormField(
      decoration: InputDecoration(
        border: OutlineInputBorder(),
        contentPadding: EdgeInsets.all(10.0),
        isDense: true,
        labelText: 'Choose type of leave',
        labelStyle: inputTextStyle,
      ),
      items: _typeOfLeaveList.map((TypeOfLeave typeOfLeave){
        return DropdownMenuItem(
          value: typeOfLeave.id.toString(),
          child: Text(typeOfLeave.name, style:TextStyle(fontSize:14.0)),
        );
      }).toList(),
      onChanged: (String selected){
        setState(() {
          this.selectedTypeOfLeave = selected; 
        });
      },
      value: selectedTypeOfLeave,
      validator: (String value){
        if(value == null || value.isEmpty){
          return 'Please choose type of leave';
        }
      },
    );
  }

  Widget descriptionInput(){
    return TextFormField(
      controller: descriptionController,
      decoration: InputDecoration(
        isDense: true,
        labelText: 'Description',
        labelStyle: inputTextStyle,
        border: OutlineInputBorder(),
        contentPadding: EdgeInsets.all(12.0),
      ),
      maxLines: 5,
      validator: (String value){
        if(value == null || value.isEmpty){
          return 'Please enter description';
        }
      },
    );
  }

  Widget dateInput(){
    return DateTimeField(
      controller: dateController,
      format: DateFormat('dd-MM-yyyy'),
      decoration: InputDecoration(
        contentPadding: EdgeInsets.all(12.0),
        labelStyle: inputTextStyle,
        labelText: 'Leave Date',
        border: OutlineInputBorder(),
        isDense: true,
      ),
      style: inputTextStyle,
      onShowPicker: (context, currentValue) async {
        final date = await showDatePicker(
          context: context,
          initialDate: currentValue ?? DateTime.now(),
          firstDate: DateTime(1995),
          lastDate: DateTime(2050),
        ); 
        return date ?? currentValue;
      },
      validator: (value){
        if(value == null){
          return 'Please choose leave date';
        }
      },
    );
  }

  Widget timeInput(){
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: <Widget>[
        Row(
          mainAxisAlignment: MainAxisAlignment.start,
          children: <Widget>[
            Expanded(
              child: RadioListTile(
                groupValue: _selectedTime,
                title: Text('Mornig', style: TextStyle(fontSize: 14.0)),
                value: 'morning',
                onChanged: (String selected){
                  setState(() {
                   _selectedTime = selected; 
                  });
                },
              ),
            ),
            Expanded(
              child: RadioListTile(
                groupValue: _selectedTime,
                title: Text('Evening', style: TextStyle(fontSize: 14.0)),
                value: 'evening',
                onChanged: (String selected){
                  setState(() {
                   _selectedTime = selected; 
                  });
                },
              ),
            ),
          ],
        ),
        _selectedTimeError != null ? Text(_selectedTimeError, style: errorStyle,) : SizedBox(),
      ],
    );
  }

  bool selectedTimeErrorCheck(){
    if(_selectedTime == null || _selectedTime.isEmpty){
      setState(() {
       this._selectedTimeError = 'Please choose morning or evening'; 
      });
      return false;
    }else{
      setState(() {
       this._selectedTimeError = null; 
      });
      return true;
    }
  }

  Widget typeOfLeaveInput2(){
    return DropdownButtonFormField(
      decoration: InputDecoration(
        border: OutlineInputBorder(),
        contentPadding: EdgeInsets.all(10.0),
        isDense: true,
        labelText: 'Choose type of leave',
        labelStyle: inputTextStyle,
      ),
      items: _typeOfLeaveList.map((TypeOfLeave typeOfLeave){
        return DropdownMenuItem(
          value: typeOfLeave.id.toString(),
          child: Text(typeOfLeave.name, style:TextStyle(fontSize:14.0)),
        );
      }).toList(),
      onChanged: (String selected){
        setState(() {
          this.selectedTypeOfLeave2 = selected; 
        });
      },
      value: selectedTypeOfLeave2,
      validator: (String value){
        if(value == null || value.isEmpty){
          return 'Please choose type of leave';
        }
      },
    );
  }

  Widget descriptionInput2(){
    return TextFormField(
      controller: descriptionController2,
      decoration: InputDecoration(
        isDense: true,
        labelText: 'Description',
        labelStyle: inputTextStyle,
        border: OutlineInputBorder(),
        contentPadding: EdgeInsets.all(12.0),
      ),
      maxLines: 5,
      validator: (String value){
        if(value == null || value.isEmpty){
          return 'Please enter description';
        }
      },
    );
  }

  Widget body(){
    return TabBarView(
      controller: _tabController,
      children: [
        Form(
          key: _fullDayFormKey,
          child: Container(
            padding: EdgeInsets.symmetric(horizontal:12.0, vertical: 20.0),
            child: ListView(
              children: <Widget>[
                Container(
                  color: Colors.red[200],
                  padding: EdgeInsets.all(10.0),
                  child: Text('Leave request is under-maintainanced. So nothing\'ll not happened when you requested leave.', style: TextStyle(color: Colors.grey[200],fontSize: 12.0),),
                ),
                SizedBox(height: 20.0,),
                employeeInputField(),
                SizedBox(height: 20.0,),
                datePeriod(),
                SizedBox(height: 20.0,),
                typeOfLeaveInput(),
                SizedBox(height: 20.0,),
                descriptionInput(),
              ],
            ),
          ),
        ),
        Form(
          key: _halfDayFormKey,
          child: Container(
            padding: EdgeInsets.symmetric(horizontal: 12.0, vertical: 20.0),
            child: ListView(
              children: <Widget>[
                Container(
                  color: Colors.red[200],
                  padding: EdgeInsets.all(10.0),
                  child: Text('Leave request is under-maintainanced. So nothing\'ll not happened when you requested leave.', style: TextStyle(color: Colors.grey[200],fontSize: 12.0),),
                ),
                SizedBox(height: 20.0,),
                employeeInputField(),
                SizedBox(height: 20.0,),
                dateInput(),
                SizedBox(height: 20.0,),
                timeInput(),
                SizedBox(height: 20.0,),
                typeOfLeaveInput2(),
                SizedBox(height: 20.0,),
                descriptionInput2(),
              ],
            ),
          ),
        ),
      ],
    );
  }

  @override
  Widget build(BuildContext context) {
    return DefaultTabController(
      length: 2,
      child: Scaffold(
        appBar: appBar(),
        body: body(),
      ),
    );
  }
}