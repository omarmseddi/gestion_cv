import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { routerTransition } from '../router.animations';
import { TestService } from '../shared/services/test.service';
import { AuthService } from '../shared/services/auth.service';
import { LoginService} from '../shared/services/login.service';
import {HttpErrorResponse} from '@angular/common/http';
import {NgForm} from '@angular/forms';
@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.scss'],
    animations: [routerTransition()]
})
export class LoginComponent implements OnInit {
  message: string;
  isLoginError = false;

  constructor(public router: Router, private testService: TestService,
              private authService: AuthService, private loginService: LoginService) {
    localStorage.setItem('userToken', null);
  }

  ngOnInit() {
  }
  onLoggedin() {
    localStorage.setItem('isLoggedin', 'true');
  }
  onSubmit(username, password) {
    this.loginService.userAuthentification(username, password).subscribe((data: any) => {
      localStorage.setItem('userToken', data['access_token']);
      this.router.navigate(['']);
    }, (err: HttpErrorResponse) => {
      this.isLoginError = true;
    });
  }
}

