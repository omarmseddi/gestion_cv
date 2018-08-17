import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClientModule } from '@angular/common/http';

import { AjouterCvRoutingModule } from './ajouterCv-routing.module';
import { AjouterCvComponent } from './ajouterCv.component';
import { PageHeaderModule } from '../../../shared/index';
import { AjouterCvService} from '../../../shared/services/ajouterCv.service';
import { FormsModule} from '@angular/forms';

@NgModule({
  imports: [CommonModule, AjouterCvRoutingModule, PageHeaderModule, HttpClientModule, FormsModule],
  declarations: [AjouterCvComponent],
  providers: [AjouterCvService]

})
export class AjouterCvModule {}
