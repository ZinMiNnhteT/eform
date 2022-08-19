import 'package:fl_chart/fl_chart.dart';
import 'package:flutter/material.dart';

class BarChartSample4 extends StatefulWidget {

  final List<dynamic> charData; 

  BarChartSample4(this.charData);

  @override
  State<StatefulWidget> createState() => BarChartSample4State(this.charData);
}

class BarChartSample4State extends State<BarChartSample4> {

  final Color dark = Colors.lightBlue[400];
  final Color normal = const Color(0xff64caad);
  final Color light = Colors.lightBlue[100];

  List<dynamic> charData; 
  BarChartSample4State(this.charData);

  List<BarChartGroupData> data = [];

  double maxY = 0;
  double gridAmount = 10;

  @override
  void initState() {
    print('char data is');
    print(charData);
    print(double.tryParse((charData[0]['all']).toString()));
    super.initState();

    for(var i=0; i<charData.length; i++){
      if(maxY < double.tryParse((charData[i]['all']).toString())){
        setState(() {
          this.maxY = double.tryParse((charData[i]['all']).toString());
        });
      }
      BarChartGroupData barGroup = BarChartGroupData(
        x: i,
        barsSpace: 4,
        barRods: [
          BarChartRodData(
            y: double.tryParse((charData[i]['all']).toString()), 
            rodStackItem: [
              BarChartRodStackItem(
                0, 
                double.tryParse((charData[i]['confirm']).toString()), 
                dark
              ),
              BarChartRodStackItem(
                double.tryParse((charData[i]['confirm']).toString()), 
                double.tryParse((charData[i]['all']).toString()), 
                light
              ),
            ], isRound: false),
        ],
      );
      data.add(barGroup);
    }
    print('maxY is');
    print(maxY);

    double totalMax = 100;
    if(maxY <= 5){
      totalMax = 5;
    }else if(maxY <= 10){
      totalMax = 10;
    }else if(maxY <= 50){
      totalMax = 50;
    }else if(maxY <= 100){
      totalMax = 100;
    }else if(maxY <= 200){
      totalMax = 5;
    }else if(maxY <= 500){
      totalMax = 500;
    }else if(maxY <= 1000){
      totalMax = 1000;
    }else{
      totalMax = 2000;
    }
    setState(() {
      this.gridAmount = totalMax / 5;
    });
    print('gird amount');
    print(this.gridAmount);
  }

  @override
  Widget build(BuildContext context) {
    return AspectRatio(
      aspectRatio: 1.66,
      child: Padding(
        padding: const EdgeInsets.only(top: 16.0),
        child: BarChart(
          BarChartData(
            alignment: BarChartAlignment.center,
            maxY: maxY,
            barTouchData: const BarTouchData(),
            titlesData: FlTitlesData(
              show: true,
              bottomTitles: SideTitles(
                showTitles: true,
                textStyle: TextStyle(
                  color: const Color(0xff939393), fontSize: 10),
                margin: 10,
                getTitles: (double value) {
                  switch (value.toInt()) {
                    case 0:
                      return 'Jan';
                    case 1:
                      return 'Feb';
                    case 2:
                      return 'Mar';
                    case 3:
                      return 'Apr';
                    case 4:
                      return 'May';
                    case 5:
                      return 'Jun';
                    case 6:
                      return 'Jul';
                    case 7:
                      return 'Aug';
                    case 8:
                      return 'Sep';
                    case 9:
                      return 'Oct';
                    case 10:
                      return 'Nov';
                    case 11:
                      return 'Dec';
                    default:
                      return '';
                  }
                },
              ),
              leftTitles: SideTitles(
                showTitles: true,
                textStyle: TextStyle(color: const Color(0xff939393,), fontSize: 10),
                getTitles: (double value) {
                  return value.toInt().toString();
                },
                interval: gridAmount,
                margin: 0,
              ),
            ),
            gridData: FlGridData(
              show: true,
              checkToShowHorizontalGrid: (value) => value % gridAmount == 0,
              getDrawingHorizontalGridLine: (value) => const FlLine(color: Color(0xffe7e8ec), strokeWidth: 1,),
            ),
            borderData: FlBorderData(
              show: false,
            ),
            groupsSpace: 20,
            barGroups: data,
          ),
        ),
      ),
    );
  }
}