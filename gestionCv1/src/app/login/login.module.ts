import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule, HTTP_INTERCEPTORS, HttpClient } from '@angular/common/http';
import { TestService } from '../shared/services/test.service';
import { AuthService } from '../shared/services/auth.service';
import { LoginService} from '../shared/services/login.service';
import { RequestInterceptorService } from '../shared/services/request-interceptor.service';
import { FormsModule } from '@angular/forms';

import { LoginRoutingModule } from './login-routing.module';
import { LoginComponent } from './login.component';

@NgModule({
    imports: [CommonModule, LoginRoutingModule, FormsModule],
    declarations: [LoginComponent],
    providers: [
    { provide: HTTP_INTERCEPTORS, useClass: RequestInterceptorService, multi: true },
    TestService,
    AuthService, LoginService,
    HttpClient
  ],
})
export class LoginModule {}
