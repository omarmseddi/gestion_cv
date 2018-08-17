import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';

@Injectable()
export class LoginService {
  readonly rootUrl = 'http://localhost/gestion_cv1/public/index.php';
  constructor(private http: HttpClient) { }
  userAuthentification(username, password) {
    const clientId = '1_62iwqitiogw0c4cocsc88wwcowk4g8ogks44c08kcsgs4048so';
    const clientSecret = 't1piywes11cw0cksc8kssowsoo8k4skkosg884ss8s888owoc';
    const grantType = 'password';
    const data = {
      'username' : username ,
      'password' : password,
      'grant_type' : grantType,
      'client_id' : clientId,
      'client_secret' : clientSecret
    };
    const reqHeader = new HttpHeaders({'Content-Type': 'application/json'});
    return this.http.post(this.rootUrl + '/oauth/v2/token', data , { headers: reqHeader});
  }
}
