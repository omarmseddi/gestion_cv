import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TablesRoutingModule } from './tables-routing.module';
import { TablesComponent } from './tables.component';
import { GridModule } from '@progress/kendo-angular-grid';
import { PageHeaderModule} from '../../shared/modules/index';
import {CvService} from '../../shared/services/cv.service';
import { SliderModule} from '@progress/kendo-angular-inputs';
import {AjouterCvModule} from './ajouterCv/ajouterCv.module';
import { AjouterCvComponent} from './ajouterCv/ajouterCv.component';

@NgModule({
    imports: [CommonModule, TablesRoutingModule, PageHeaderModule, GridModule, SliderModule, AjouterCvModule],
    declarations: [TablesComponent],
    providers: [CvService]
})
export class TablesModule {}
