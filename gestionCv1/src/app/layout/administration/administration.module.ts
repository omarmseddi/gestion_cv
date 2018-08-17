import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClientModule } from '@angular/common/http';

import {AdministrationRoutingModule} from './administration-routing.module';
import { AdministrationComponent } from './administration.component';
import {AdministrationService} from '../../shared/services/administrationService';
import {FormsModule} from '@angular/forms';
import {PageHeaderModule} from '../../shared/modules';

@NgModule({
  imports: [CommonModule, AdministrationRoutingModule, PageHeaderModule, HttpClientModule, FormsModule],
  declarations: [AdministrationComponent],
  providers: [AdministrationService]

})
export class AdministrationModule {}
