import {HttpClient, HttpClientModule, HttpHeaders, HttpResponse} from '@angular/common/http';
import {Injectable} from '@angular/core';
import {Observable} from 'rxjs';
import {catchError, map, tap} from 'rxjs/operators';
import {ICV} from '../../layout/tables/cvs';
import {ICategorie} from '../../layout/tables/categorie';
import {ITechnologie} from '../../layout/tables/technologie';

@Injectable()
export class AjouterCvService {
  private Url = 'http://localhost/gestion_cv1/public/index.php/api';

  constructor (private _http: HttpClient ) {}

  getCategorie(): Observable<ICategorie[]> {
    const usertoken = localStorage.getItem('userToken');
    const reqHeader = new HttpHeaders({'Content-Type': 'application/json', 'Authorization': 'Bearer ' + usertoken });
    return this._http.get<ICategorie[]>(this.Url + '/categories', { headers: reqHeader})
      .pipe(
        map(res => res));
  }
  getTechnologie(): Observable<ITechnologie[]> {
    const usertoken = localStorage.getItem('userToken');
    const reqHeader = new HttpHeaders({'Content-Type': 'application/json', 'Authorization': 'Bearer ' + usertoken });
    return this._http.get<ITechnologie[]>(this.Url + '/technologies/status', { headers: reqHeader})
      .pipe(
        map(res => res));
  }

  postCv(nom, prenom, formData, categorie, mission, disponibilite, technologie): Observable<any> {
    let technos = [];
    for (let techno of technologie) {
      technos = technos.concat([{'nom': techno}]);

    }
    const usertoken = localStorage.getItem('userToken');
    const data = {
      'nom' : nom ,
      'prenom' : prenom,
      'categorie' : {'nom': categorie},
      'mission' : !mission,
      'disponibilite' : !disponibilite,
      'technologies' : technos
    };
    formData.append('cv', JSON.stringify(data));
    const reqHeader = new HttpHeaders({'Content-Type': 'form-data', 'Authorization': 'Bearer ' + usertoken });
    return this._http.post<ICV>(this.Url + '/c_vs', formData , { headers: reqHeader});
  }

}
