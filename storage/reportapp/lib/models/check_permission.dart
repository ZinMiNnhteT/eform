class CheckPermission{

  String goToLink;

  String getRouteNameByPermission(String permissionName){
    switch(permissionName){
      case "office_3-index-read" : 
        return '/office_management'; break;
      case "office_3-report-read" : 
        return goToLink = '/service_report'; break; 
      default:
        return '';
    }
  }

  CheckPermission.getRouteToGo(List<String> givenPermissions){

    List<String> routesOfOfficeModule = [
      "office_3-index-read","office_3-report-read",  
    ];

    String linkName = '';

    for(int i = 0; i < routesOfOfficeModule.length; i++){
      if(givenPermissions.contains(routesOfOfficeModule[i])){
        linkName = getRouteNameByPermission(routesOfOfficeModule[i]);
        if(linkName != ''){
          this.goToLink = linkName;
          break;
        }
      }
    }
  }

  

}