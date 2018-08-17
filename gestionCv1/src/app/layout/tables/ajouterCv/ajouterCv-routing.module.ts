import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AjouterCvComponent } from './ajouterCv.component';

const routes: Routes = [
    {
        path: '', component: AjouterCvComponent
    }
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})
export class AjouterCvRoutingModule {
}
