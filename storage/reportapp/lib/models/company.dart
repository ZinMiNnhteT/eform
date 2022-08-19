class Company{
  String companyId;
  String companyName;
  String address;
  String tel;

  Company({this.companyId, this.companyName, this.address, this.tel});
  Company.withEmptyData();
  
  Company.mapToObject(Map<String, dynamic> map){
    this.companyId = map['companyId'];
    this.companyName = map['companyName'];
    this.address = map['address'];
    this.tel = map['tel'];
  }
}