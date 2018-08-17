import {HttpClient, HttpHeaders} from '@angular/common/http';
import {Injectable} from '@angular/core';
import {Observable} from 'rxjs';
import { map} from 'rxjs/operators';
import {ICategorie} from '../../layout/tables/categorie';
import {ITechnologie} from '../../layout/tables/technologie';

@Injectable()
export class AdministrationService {
  private Url = 'http://localhost/gestion_cv1/public/index.php/api';

  constructor(private _http: HttpClient) {
  }
  getCategorie(): Observable<ICategorie[]> {
    const usertoken = localStorage.getItem('userToken');
    const reqHeader = new HttpHeaders({'Content-Type': 'application/json', 'Authorization': 'Bearer ' + usertoken });
    return this._http.get<ICategorie[]>(this.Url + '/categories', { headers: reqHeader} )
      .pipe(
        map(res => res));
  }
  getTechnologie(): Observable<ITechnologie[]> {
    const usertoken = localStorage.getItem('userToken');
    const reqHeader = new HttpHeaders({'Content-Type': 'application/json', 'Authorization': 'Bearer ' + usertoken });
    return this._http.get<ITechnologie[]>(this.Url + '/technologies', { headers: reqHeader})
      .pipe(
        map(res => res));
  }

  postCategorie(nom: string): Observable<ICategorie> {
    const data = {
      'nom' : nom
    };
    const usertoken = localStorage.getItem('userToken');
    const reqHeader = new HttpHeaders({'Content-Type': 'application/json', 'Authorization': 'Bearer ' + usertoken });
    return this._http.post<ICategorie>(this.Url + '/categories', data , { headers: reqHeader});
  }
  postTechnologie(nom: string, status): Observable<ITechnologie> {

    const data = {
      'nom' : nom,
      'status' : !status
    };
    const usertoken = localStorage.getItem('userToken');
    const reqHeader = new HttpHeaders({'Content-Type': 'application/json', 'Authorization': 'Bearer ' + usertoken });
    console.log(data);
    return this._http.post<ITechnologie>(this.Url + '/technologies', data , { headers: reqHeader});
  }

  deleteTechnologie(id) {
    const usertoken = localStorage.getItem('userToken');
    const reqHeader = new HttpHeaders({'Content-Type': 'application/json', 'Authorization': 'Bearer ' + usertoken });
    return this._http.delete<ITechnologie>(this.Url + '/technologies/' + id , { headers: reqHeader});
  }
  deleteCategorie(id) {
    const usertoken = localStorage.getItem('userToken');
    const reqHeader = new HttpHeaders({'Content-Type': 'application/json', 'Authorization': 'Bearer ' + usertoken });
    return this._http.delete<ICategorie>(this.Url + '/categories/' + id , { headers: reqHeader});
  }

  putCategorie(nom: string, id): Observable<ICategorie> {
    const data = {
      'nom' : nom
    };
    const usertoken = localStorage.getItem('userToken');
    const reqHeader = new HttpHeaders({'Content-Type': 'application/json', 'Authorization': 'Bearer ' + usertoken });
    return this._http.put<ICategorie>(this.Url + '/categories/' + id, data , { headers: reqHeader});
  }
  putTechnologie(nom: string, status, id): Observable<ITechnologie> {

    const data = {
      'nom' : nom,
      'status' : status
    };
    const usertoken = localStorage.getItem('userToken');
    const reqHeader = new HttpHeaders({'Content-Type': 'application/json', 'Authorization': 'Bearer ' + usertoken });
    return this._http.put<ITechnologie>(this.Url + '/technologies/' + id, data , { headers: reqHeader});
  }
}
