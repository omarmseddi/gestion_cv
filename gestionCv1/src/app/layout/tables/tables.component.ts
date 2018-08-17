import { Component } from '@angular/core';
import { routerTransition } from '../../router.animations';
import {CvService} from '../../shared/services/cv.service';
import {ICV} from './cvs';
import { Router} from '@angular/router';
import {
  GridDataResult,
  DataStateChangeEvent
} from '@progress/kendo-angular-grid';
import {State, process} from '@progress/kendo-data-query';
@Component({
    selector: 'app-tables',
    templateUrl: './tables.component.html',
    styleUrls: ['./tables.component.scss'],
    animations: [routerTransition()]
})

export class TablesComponent {
  public href ;
  public class = 'not-active';
  public cvs: ICV[] = [];
  public buttonCount = 5;
  public info = true;
  public type: 'numeric' | 'input' = 'numeric';
  public pageSizes = true;
  public  pageSize = 5;
  public previousNext = true;
  public state: State = {
    skip: 0,
    take : 2,
    filter: {
      logic: 'and',
      filters: [{ field: 'nom', operator: 'contains', value: '' }]
    },
    group: [{ field: 'grouping here' }],
    sort: [{
      field: 'nom',
      dir: 'desc'
    }],
  };
  public gridView: GridDataResult;
  public numItems ;
  public i = 0;
  public firstSubmit = true;
    constructor(private cvservice: CvService) {
      this.onSubmit();

    }
  protected dataStateChange( event: DataStateChangeEvent): void {
    this.state = event;
    if (! this.state.group.length) {
      this.state.group[0].field = 'grouping here';
    }
    this.onSubmit();
  }
  private loadCVS(): void {

        this.gridView = {
          data: this.cvs.slice(0, this.state.take),
          total: this.numItems
        };
        console.log(this.cvs);
/*
    this.gridView = process(this.cvs, { group: this.state.group });
*/


  }

  public removeHandler({dataItem}) {
    this.cvservice.deleteCvs(dataItem.id).subscribe((data) => {

      this.onSubmit();
    });
  }
  getFile(id) {
      this.cvservice.connectSP(id).subscribe((data) => {
        window.location.href = '' + data;
      });
  }
  onSubmit() {

    this.i = this.state.filter.filters.length - 1;
    if (!this.state.sort[0].dir) {
      this.state.sort[0].dir = null;
    }
    if (this.state.filter.filters[this.i]['value'] === false &&
      (this.state.filter.filters[this.i]['field'] === 'mission' || this.state.filter.filters[this.i]['field'] === 'disponibilite')) {
      this.state.filter.filters[this.i]['value'] = '0';
    }
    console.log(this.state.filter);
    /*    if (this.firstSubmit || this.state.group.length === 0) {*/


    console.log(this.state.take);
    console.log(this.state.skip);
    console.log(this.state.sort[0].dir);
    console.log(this.state.sort[0].field);
    console.log(this.state.filter.filters[this.i]['field']);
    console.log(this.state.filter.filters[this.i]['value']);
    console.log(this.state.group[0]['field']);
    /*     if (this.state.group[0]['field'] === 'id') {
           console.log(this.numItems);
           this.state.take = this.numItems;
           this.state.skip = 0;
         }*/
    if (this.state.group[0].field === 'grouping here') {
    this.cvservice.getCvs(this.state.take, this.state.skip, this.state.sort[0].dir, this.state.sort[0].field
      , this.state.filter.filters[this.i]['field'], this.state.filter.filters[this.i]['value']).subscribe((cvs) => {
        this.cvs = cvs;
        if (this.firstSubmit) {
          this.numItems = this.cvs[0].numItems;
        }
        this.firstSubmit = false;
        this.loadCVS();
      }
    );
    } else {
      this.cvservice.getCvsGroup(this.state.take, this.state.skip, this.state.sort[0].dir, this.state.sort[0].field
        , this.state.filter.filters[this.i]['field'], this.state.filter.filters[this.i]['value'],
        this.state.group[0].field).subscribe((cvs) => {
        this.cvs = cvs;
        this.loadCVS();
      });


      /*this.numItems = this.cvs[0].numItems;*/

    }
/*  OnConnect(){
    this.cvservice.connect().subscribe((data) => {
      this.list = data[0]
    })
  }*/
}
}



