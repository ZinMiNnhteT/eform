import 'package:flutter/material.dart';
import 'package:reportapp/models/customer.dart';
import 'package:reportapp/models/quotation.dart';
import 'package:reportapp/screens/utils/office_drawer.dart';

class QuotationForm extends StatefulWidget {
  @override
  _QuotationFormState createState() => _QuotationFormState();
}

class _QuotationFormState extends State<QuotationForm> {

  var _quotationFormKey = GlobalKey<FormState>();
  String selectedRefNo;
  String selectedAttnName;
  Customer selectedCustomer;
  String selectedCurrency;
  String currencyValidateError = '';

  TextEditingController referNoController = TextEditingController();
  TextEditingController attnNameController = TextEditingController();
  TextEditingController companyNameController = TextEditingController();
  TextEditingController phoneNoController = TextEditingController();
  TextEditingController addressController = TextEditingController();
  TextEditingController subjectController = TextEditingController();
  TextEditingController quoDateController = TextEditingController();
  
  List<Quotation> quotationList = [
    Quotation(id: 1, quoNo: 'QN-201902233123',attn: 'Saw Aung Aung Moe',company: 'British Council',phoneNo: '0943484-47-', address: '', subject:'Cisco Switch and AP quotation', date:'25-10-2019'),
    Quotation(id: 2, quoNo: 'QN-201902233123',attn: 'Ko Kyaw Thet Naung',company: 'Myanmar Jardine Schindler Ltd.',phoneNo: '0943484-47-', address: '', subject:'Cisco Phone Quotation', date:'25-10-2019'),
    Quotation(id: 3, quoNo: 'QN-201902233123',attn: 'PTTEP INTERNATIONAL LIMITED (YANGON BRANCH OFFICE)',company: 'PTTEP INTERNATIONAL LIMITED (YANGON BRANCH OFFICE)',phoneNo: '0943484-47-', address: '', subject:'RFQ No. 13000417621-655 _ Supply of IT equipment for ZPQ ICT activities', date:'25-10-2019'),
    Quotation(id: 4, quoNo: 'QN-201902233123',attn: 'Ko Aung Phyo',company: 'Creative Web Studio',phoneNo: '0943484-47-', address: '', subject:'Dell Server RAM (ECC 32Gb)', date:'25-10-2019'),
    Quotation(id: 5, quoNo: 'QN-201902233123',attn: 'Thein Min Htike',company: 'clicktop.org',phoneNo: '0943484-47-', address: '', subject:'Domain and Hosting Renual', date:'25-10-2019'),
    Quotation(id: 6, quoNo: 'QN-201902233123',attn: 'Saw Aung Aung Moe',company: 'British Council',phoneNo: '0943484-47-', address: '', subject:'Cisco Switch and AP quotation', date:'25-10-2019'),
    Quotation(id: 7, quoNo: 'QN-201902233123',attn: 'Ko Kyaw Thet Naung',company: 'Myanmar Jardine Schindler Ltd.',phoneNo: '0943484-47-', address: '', subject:'Cisco Phone Quotation', date:'25-10-2019'),
    Quotation(id: 8, quoNo: 'QN-201902233123',attn: 'PTTEP INTERNATIONAL LIMITED (YANGON BRANCH OFFICE)',company: 'PTTEP INTERNATIONAL LIMITED (YANGON BRANCH OFFICE)',phoneNo: '0943484-47-', address: '', subject:'RFQ No. 13000417621-655 _ Supply of IT equipment for ZPQ ICT activities', date:'25-10-2019'),
    Quotation(id: 9, quoNo: 'QN-201902233123',attn: 'Ko Aung Phyo',company: 'Creative Web Studio',phoneNo: '0943484-47-', address: '', subject:'Dell Server RAM (ECC 32Gb)', date:'25-10-2019'),
    Quotation(id: 10, quoNo: 'QN-201902233123',attn: 'Thein Min Htike',company: 'clicktop.org',phoneNo: '0943484-47-', address: '', subject:'Domain and Hosting Renual', date:'25-10-2019'),
  ];

  List<Customer> customerList = [
    Customer(id: 1, name: 'Ko Auny Phyo', companyName: 'Creeative Web Studio', companyAddress: 'Yangon', phoneNo: '0934347-2'),
    Customer(id: 2, name: 'Thein Min Htike', companyName: 'clicktop.org', companyAddress: 'Mandalay', phoneNo: '0934347-1'),
    Customer(id: 3, name: 'Saw Aung Aung Moe', companyName: 'PTTEP INTERNATIONAL LIMITED', companyAddress: 'Naypyidaw', phoneNo: '0934347-3'),
  ];

  DropdownButtonFormField referNo(){
    return DropdownButtonFormField<String>(
      decoration: InputDecoration(
        contentPadding: EdgeInsets.symmetric(vertical: 10.0, horizontal: 10.0),
        labelText: 'Select Refer No.',
        labelStyle: TextStyle(fontSize: 14.0),
        border: OutlineInputBorder(),
        isDense: true,
        
      ),
      items: quotationList.map((Quotation quo){
        return DropdownMenuItem<String>(
          value: quo.id.toString(),
          child: Text(
            quo.quoNo,
            style: TextStyle(fontSize: 14.0),
          ),
        );
      }).toList(),
      onChanged: (String selected){
        setState(() {
          this.selectedRefNo = selected;
        });
      },
      value: selectedRefNo,
    );
  }

  DropdownButtonFormField attnName(){
    return DropdownButtonFormField<String>(
      decoration: InputDecoration(
        contentPadding: EdgeInsets.symmetric(vertical: 10.0, horizontal: 10.0),
        labelText: 'Select Attn Name',
        labelStyle: TextStyle(fontSize: 14.0),
        border: OutlineInputBorder(),
        isDense: true,
      ),
      items: customerList.map((Customer customer){
        return DropdownMenuItem<String>(
          value: customer.id.toString(),
          child: Text(
            customer.name,
            style: TextStyle(fontSize: 14.0),
          ),
        );
      }).toList(),
      onChanged: (String selected){
        setState(() {
          this.selectedAttnName = selected;
          this.selectedCustomer = getCustomer(int.parse(selected));
          this.companyNameController.text = this.selectedCustomer.companyName;
          this.phoneNoController.text = this.selectedCustomer.phoneNo;
          this.addressController.text = this.selectedCustomer.companyAddress;
        });
      },
      value: selectedAttnName,
      validator: (String value){
        if(value == null || value.isEmpty){
          return 'Please choose Attn Name';
        }
      },
    );
  }

  Customer getCustomer(int id) {
    for (Customer customer in this.customerList) {
      if (customer.id == id) return customer;
    }
    return null;
  }

  bool validateCurrency(){
    if(selectedCurrency != null){
      setState(() {
        currencyValidateError = ''; 
      });
      return true;
    }else{
      setState(() {
        currencyValidateError = 'Please choose currency'; 
      });
      return false;
    }
  }

  TextFormField companyName(){
    return TextFormField(
      controller: companyNameController,
      enabled: false,
      style: TextStyle(
        fontSize: 14.0,
        color: Colors.grey,
      ),
      decoration: InputDecoration(
        contentPadding: EdgeInsets.symmetric(vertical: 12.0, horizontal: 12.0),
        labelText: 'Company Name',
        border: OutlineInputBorder(),
        filled: true,
        fillColor: Colors.grey[200]
      ),
    );
  }

  TextFormField phoneNo(){
    return TextFormField(
      controller: phoneNoController,
      enabled: false,
      style: TextStyle(
        fontSize: 14.0,
        color: Colors.grey,
      ),
      decoration: InputDecoration(
        contentPadding: EdgeInsets.symmetric(vertical: 12.0, horizontal: 12.0),
        labelText: 'Phone Number',
        border: OutlineInputBorder(),
        filled: true,
        fillColor: Colors.grey[200],
      ),
    );
  }

  TextFormField address(){
    return TextFormField(
      controller: addressController,
      enabled: false,
      style: TextStyle(
        fontSize: 14.0,
        color: Colors.grey,
      ),
      decoration: InputDecoration(
        contentPadding: EdgeInsets.symmetric(vertical: 12.0, horizontal: 12.0),
        labelText: 'Address',
        border: OutlineInputBorder(),
        filled: true,
        fillColor: Colors.grey[200],
      ),
      maxLines: 5,
    );
  }

  TextFormField subject(){
    return TextFormField(
      controller: subjectController,
      style: TextStyle(
        fontSize: 14.0,
      ),
      decoration: InputDecoration(
        contentPadding: EdgeInsets.symmetric(vertical: 12.0, horizontal: 12.0),
        labelText: 'Subject',
        border: OutlineInputBorder(),
      ),
      validator: (String value){
        if(value == null || value.isEmpty){
          return 'Please enter subject';
        }
      },
    );
  }

  TextFormField quoDate(){
    return TextFormField(
      controller: quoDateController,
      style: TextStyle(
        fontSize: 14.0,
      ),
      decoration: InputDecoration(
        contentPadding: EdgeInsets.symmetric(vertical: 12.0, horizontal: 12.0),
        labelText: 'Date',
        border: OutlineInputBorder(),
      ),
      validator: (String value){
        if(value == null || value.isEmpty){
          return 'Please choose date';
        }
      },
    );
  }

  FlatButton backButton(BuildContext context){
    return FlatButton(
      padding: EdgeInsets.all(12.0),
      color: Colors.grey,
      onPressed: (){
        Navigator.pushNamed(context, '/quotation_list');
      },
      child: Text('Back', style: TextStyle(color: Colors.white),),
      shape: OutlineInputBorder(
        borderRadius: BorderRadius.circular(30.0),
        borderSide: BorderSide.none,
      ),
    );
  }

  FlatButton saveButton(BuildContext context){
    return FlatButton(
      padding: EdgeInsets.all(12.0),
      color: Colors.lightBlue,
      onPressed: (){
        if(_quotationFormKey.currentState.validate() & validateCurrency()){
          Navigator.pushNamed(context, '/office_management');
        }
      },
      child: Text('Save & Next', style: TextStyle(color: Colors.white),),
      shape: OutlineInputBorder(
        borderRadius: BorderRadius.circular(30.0),
        borderSide: BorderSide.none,
      ),
    );
  }


  Widget currency(){
    return Column(
      children: <Widget>[
        Row(
          children: <Widget>[
            Expanded(
              flex: 3,
              child: Text('Currency')
            ),
            Expanded(
              flex: 2,
              child: Row(
                children: <Widget>[
                  Radio(
                    value: 'MMK',
                    groupValue: selectedCurrency,
                    onChanged: (String selected){
                      setState(() {
                       this.selectedCurrency =  selected;
                      });
                    },
                  ),
                  Text('MMK')
                ],
              ),
            ),
            Expanded(
              flex: 2,
              child: Row(
                children: <Widget>[
                  Radio(
                    value: 'USD',
                    groupValue: selectedCurrency,
                    onChanged: (String selected){
                      setState(() {
                       this.selectedCurrency =  selected;
                      });
                    },
                  ),
                  Text('USD'),
                ],
              ),
            ),
          ],
        ),
        Row(
          children: <Widget>[
            Padding(
              padding: const EdgeInsets.only(left: 12.0),
              child: Text(
                currencyValidateError, 
                style: TextStyle(
                  color: Colors.red[800],fontSize: 12.0
                ),
                textAlign: TextAlign.left,
              ),
            ),
          ],
        ),
      ],
    );
    
  }

  Widget appBar(){
    return AppBar(
      title: Text(
        'Add New Quotation',
        style: TextStyle(
          color: Colors.white,
          fontSize: 16.0,
        ),
      ),
    );
  }
 
  Widget get body{
    return Form(
      key: _quotationFormKey,
      child: ListView(
        children: <Widget>[
          referNo(),
          SizedBox(height: 12.0,),
          attnName(),
          SizedBox(height: 12.0,),
          companyName(),
          SizedBox(height: 12.0,),
          phoneNo(),
          SizedBox(height: 12.0,),
          address(),
          SizedBox(height: 12.0,),
          subject(),
          SizedBox(height: 12.0,),
          quoDate(),
          SizedBox(height: 12.0,),
          currency(),
          SizedBox(height: 12.0,),
          Row(
            children: <Widget>[
              Expanded(
                child:backButton(context), 
              ),
              SizedBox(width: 12.0,),
              Expanded(
                child: saveButton(context), 
              ),
            ],
          ),
        ],
      ),
    );
  } 
  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: appBar(),
      body:  Padding(
        padding: const EdgeInsets.all(12.0),
        child: body,
      ),
      drawer: OfficeDrawer(),
    );
  }
}