class ServiceReportItem{
  String serviceId;
  String serviceName;
  String chargeAmount;
  String reportId;

  ServiceReportItem({this.serviceId, this.serviceName, this.chargeAmount, this.reportId});

  ServiceReportItem.mapToObject(Map<String,dynamic> map){
    this.serviceId    = map['serviceId'];
    this.serviceName  = map['serviceName'];
    this.chargeAmount = map['ChargeAmount'];
    this.reportId     = map['reportId'];
  }
}