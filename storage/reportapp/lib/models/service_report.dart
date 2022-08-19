class ServiceReport{

  String reportId;
  String company;
  String reportDateINT;
  String contactPerson;
  String contactTel;
  String errorRemark;
  String serviceCode;
  String engineer;
  String receive; 
  String signature1;
  String signature2;
  String duration;
  String editStatus;
  String reportDate;
  String currencyType;
  String companyId;
  String companyName;
  String address;
  String tel;

  ServiceReport({
    this.reportId,
    this.company,
    this.reportDateINT,
    this.contactPerson,
    this.contactTel,
    this.errorRemark,
    this.serviceCode,
    this.engineer,
    this.receive, 
    this.signature1,
    this.signature2,
    this.duration,
    this.editStatus,
    this.reportDate,
    this.currencyType,
    this.companyId,
    this.companyName,
    this.address,
    this.tel
  });

  ServiceReport.emptyData();

  ServiceReport.mapToObject(Map<String, dynamic> map){
    this.reportId = map['reportId'];
    this.company = map['company'];
    this.reportDateINT = map['reportDate_INT'];
    this.contactPerson = map['contactPerson'];
    this.contactTel = map['contactTel']; 
    this.errorRemark = map['errorRemark']; 
    this.serviceCode = map['serviceCode']; 
    this.engineer = map['engineer']; 
    this.receive = map['receive'];  
    this.signature1 = map['signature1']; 
    this.signature2 = map['signature2']; 
    this.duration = map['duration']; 
    this.editStatus = map['editStatus']; 
    this.reportDate = map['reportDate']; 
    this.currencyType = map['Currency_type']; 
    this.companyId = map['companyId']; 
    this.companyName = map['companyName']; 
    this.address = map['address']; 
    this.tel = map['tel']; 
  }

}