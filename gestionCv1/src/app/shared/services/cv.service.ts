import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {map} from 'rxjs/operators';
import {Observable} from 'rxjs';
import {ICV} from '../../layout/tables/cvs';

@Injectable()
export class CvService {
  readonly rootUrl = 'http://localhost/gestion_cv1/public/index.php';
  constructor(private http: HttpClient) { }
  getCvs(take, skip, ordre, colonne , search , value): Observable<ICV[]> {
    const usertoken = localStorage.getItem('userToken');
    const data = {
      'take': take,
      'skip': skip,
      'ordre': ordre,
      'colonne': colonne,
      'search': search,
      'value': value,
      'grouping': false
    };
    const reqHeader = new HttpHeaders({'Content-Type': 'application/json', 'Authorization': 'Bearer ' + usertoken });
    return this.http.post<ICV[]>(this.rootUrl + '/api/cv', data , { headers: reqHeader}).pipe( map(res => res));
  }
  getCvsGroup(take, skip, ordre, colonne , search , value, group): Observable<ICV[]> {
    const usertoken = localStorage.getItem('userToken');
    const data = {
      'take': take,
      'skip': skip,
      'ordre': ordre,
      'colonne': colonne,
      'search': search,
      'value': value,
      'group': group,
      'grouping': true
    };
    const reqHeader = new HttpHeaders({'Content-Type': 'application/json', 'Authorization': 'Bearer ' + usertoken });
    /*
        return this.http.get<ICV[]>(this.rootUrl + '/api/c_vs', { headers: reqHeader}).pipe( map(res => res));
    */
    return this.http.post<ICV[]>(this.rootUrl + '/api/cv', data , { headers: reqHeader}).pipe( map(res => res));
  }
  deleteCvs(id) {
    const usertoken = localStorage.getItem('userToken');
    const reqHeader = new HttpHeaders({'Content-Type': 'application/json', 'Authorization': 'Bearer ' + usertoken });
    return this.http.delete(this.rootUrl + '/api/c_vs/' + id , { headers: reqHeader}).pipe( map(res => res));
  }
  getLogger() {
    const usertoken = localStorage.getItem('userToken');
    const reqHeader = new HttpHeaders({'Content-Type': 'application/json', 'Authorization': 'Bearer ' + usertoken });
    return this.http.get<any[]>(this.rootUrl + '/api/getLogger', { headers: reqHeader}).pipe( map(res => res));
  }
  connectSP(id) {
    console.log(id);
    const usertoken = localStorage.getItem('userToken');
    const reqHeader = new HttpHeaders({'Content-Type': 'application/json', 'Authorization': 'Bearer ' + usertoken });
    return this.http.get<any[]>(this.rootUrl + '/api/sharePoint/' + id , { headers: reqHeader}).pipe( map(res => res));
  }
}
