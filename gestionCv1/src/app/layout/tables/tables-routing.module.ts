import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { TablesComponent } from './tables.component';
const routes: Routes = [
  {
    path: '',
    component: TablesComponent,
    children: [
      {path: 'ajouterCv', loadChildren: './ajouterCv/ajouterCv.module#AjouterCvModule'}
    ]
  }
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})
export class TablesRoutingModule {
}
