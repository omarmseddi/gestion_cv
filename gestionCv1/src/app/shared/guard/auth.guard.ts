import { Injectable } from '@angular/core';
import { CanActivate } from '@angular/router';
import { Router } from '@angular/router';

@Injectable()
export class AuthGuard implements CanActivate {
    constructor(private router: Router) {}

    canActivate() {
      console.log(localStorage.getItem('userToken'));
        if (localStorage.getItem('userToken') !== 'null') {
          console.log('hi');
            return true;
        }

        this.router.navigate(['/login']);
        return false;
    }
}
