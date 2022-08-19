import 'package:flutter/material.dart';
import 'package:reportapp/models/quotation.dart';
import 'package:reportapp/screens/utils/office_drawer.dart';
import 'package:flutter_slidable/flutter_slidable.dart';

class QuotationList extends StatefulWidget {
  @override
  _QuotationListState createState() => _QuotationListState();
}

class _QuotationListState extends State<QuotationList> {

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

  Widget itemList(){
    return ListView.builder(
      itemCount: quotationList.length,
      itemBuilder: (context, index){
        return Container(
          decoration: BoxDecoration(
            border: Border(bottom: BorderSide(color: Colors.grey[300])),
          ),
          child: ListTile(
            title: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: <Widget>[
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: <Widget>[
                    Text(quotationList[index].quoNo, style: TextStyle(fontSize: 13.0,color: Colors.lightBlue),),
                    Text(quotationList[index].date, style: TextStyle(fontSize: 12.0,color: Colors.red),),
                  ],
                ),
                Text(quotationList[index].attn, style: TextStyle(fontSize: 13.0),),
              ],
            ),
            subtitle: Text(quotationList[index].subject, style: TextStyle(fontSize: 12.0),),
            onLongPress: (){
              print('long press');
            },
            onTap: (){
              print('tap this');
            },
          ),
        );
      },
    );
  }

  Widget swipListItem(){
    return Slidable(
      actionPane: SlidableDrawerActionPane(),
      actionExtentRatio: 0.25,
      child: Container(
        color: Colors.white,
        child: ListTile(
          leading: CircleAvatar(
            backgroundColor: Colors.indigoAccent,
            child: Text('text'),
            foregroundColor: Colors.white,
          ),
          title: Text('Tile'),
          subtitle: Text('SlidableDrawerDelegate'),
        ),
      ),
      actions: <Widget>[
        IconSlideAction(
          caption: 'Archive',
          color: Colors.blue,
          icon: Icons.archive,
          onTap: () => _showSnackBar('Archive'),
        ),
        IconSlideAction(
          caption: 'Share',
          color: Colors.indigo,
          icon: Icons.share,
          onTap: () => _showSnackBar('Share'),
        ),
      ],
      secondaryActions: <Widget>[
        IconSlideAction(
          caption: 'More',
          color: Colors.black45,
          icon: Icons.more_horiz,
          onTap: () => _showSnackBar('More'),
        ),
        IconSlideAction(
          caption: 'Delete',
          color: Colors.red,
          icon: Icons.delete,
          onTap: () => _showSnackBar('Delete'),
        ),
      ],
    );
  }

  // delete snackbar
  void _showSnackBar(String message){
    final snackbar = SnackBar(content: Text(message),);
    Scaffold.of(context).showSnackBar(snackbar);
  }

  Widget search(){
    return TextFormField(
      autofocus: false,
      decoration: InputDecoration(
        prefixIcon: Icon(Icons.search),
        hintStyle: TextStyle(fontSize: 13.0),
        hintText: 'Search Quotation',
        contentPadding: EdgeInsets.symmetric(vertical:0.0, horizontal:20.0),
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(30.0),
        ),
      ),
      style: TextStyle(fontSize: 14.0),
    );
  }

  @override
  Widget body() {
    return Container(
      child: Stack(
        children: <Widget>[
          Padding(
            padding: EdgeInsets.all(10.0),
            child: new Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: <Widget>[
                Container(
                  child: search(),
                ),
                SizedBox(height: 10.0,),
                Expanded(
                  child: itemList(),
                ),
                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: <Widget>[
                    RaisedButton(
                      padding: EdgeInsets.all(0.0),
                      onPressed: (){},
                      child: Text('Previous', 
                        style: TextStyle(
                          fontSize: 12.0,
                        ),
                      ),
                      color: Colors.grey,
                    ),
                    RaisedButton(
                      padding: EdgeInsets.all(0.0),
                      onPressed: (){},
                      child: Text('Next', 
                        style: TextStyle(
                          fontSize: 12.0,
                        ),
                      ),
                      color: Colors.lightBlueAccent,
                    ),
                  ],
                ),
                Expanded(child: swipListItem()),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget appBar(){
    return AppBar(
      title: Row(
        children: <Widget>[
          Expanded(
            flex: 9,
            child: Text(
              'Quotation',
              style: TextStyle(
                color: Colors.white,
                fontSize: 16.0,
              ),
            ),
          ),
          Expanded(
            flex: 1,
            child: IconButton(
              onPressed: (){
                Navigator.pushNamed(context, '/quotation_form');
              },
              icon: Icon(Icons.add, color: Colors.white,),
            ),
          ),
        ],
      ),
    );
  }  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: appBar(),
      body: body(),
      drawer: OfficeDrawer(),
    );
  }
}