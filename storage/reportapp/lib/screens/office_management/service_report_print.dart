import 'package:flutter/material.dart';

import 'package:pdf/pdf.dart';
import 'package:pdf/widgets.dart' as pdf;
import 'package:printing/printing.dart';

// import 'package:html/dom.dart';

class ServiceReportPrint extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: Scaffold(
        appBar: AppBar(
          title: Text('Printing Demo'),
        ),
        floatingActionButton: FloatingActionButton(
          child: const Icon(Icons.print),
          tooltip: 'Print Document',
          onPressed: () {
            Printing.layoutPdf(
              onLayout: buildPdf,
            );
          },
        ),
        body: Center(
          child: Text('Click on the print button below'),
        ),
      ),
    );
  }

  List<int> buildPdf(PdfPageFormat format) {
    final doc = pdf.Document();

    doc.addPage(
      pdf.Page(
        pageFormat: format,
        build: (pdf.Context context) {
          return pdf.ConstrainedBox(
            constraints: const pdf.BoxConstraints.expand(),
            child: pdf.FittedBox(
              child: pdf.Text(
                'Hello World',
              ),
            ),
          );
        },
      ),
    );

    return doc.save();
  }
}