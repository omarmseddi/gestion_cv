import {Component, OnInit, ViewChild} from '@angular/core';
import {NgForm} from '@angular/forms';
import {NgModel} from '@angular/forms';
import {ICategorie} from '../tables/categorie';
import {AjouterCvService} from '../../shared/services/ajouterCv.service';
import {ITechnologie} from '../tables/technologie';
import {AdministrationService} from '../../shared/services/administrationService';
import {routerTransition} from '../../router.animations';

@Component({
  selector: 'app-CV',
  templateUrl: './administration.component.html',
  styleUrls: ['./administration.component.scss'],
  animations: [routerTransition()]
})
export class AdministrationComponent implements OnInit {

  categories: ICategorie;
  technologies: ITechnologie[];
  catError: string;
  techError: string;
  showInputT = 0;
  showInputC: any;
  constructor(private categorieService: AdministrationService,
              private  technologieService: AdministrationService,
  ) {
  }

  ngOnInit(): void {
    this.afficheTechCat();
  }

  afficheTechCat() {
    this.categorieService.getCategorie()
      .subscribe(categories => {
        this.categories = categories['hydra:member'];
      });
    this.technologieService.getTechnologie()
      .subscribe(technologies => {
        this.technologies = technologies['hydra:member'];

      });
  }


  onSubmitCategorie(fcat: NgForm) {
    if (!fcat.value.nom) {
      this.catError = '*Ce champs ne doit pas être vide';
      console.log('Error:champs nom vide!');
      return 0;
    }
    this.categorieService.postCategorie(fcat.value.nom).subscribe(res => {
      this.afficheTechCat();
      fcat.reset();
    });

  }

  onSubmitTechnologie(ftech: NgForm) {
    console.log(ftech.value);
    if (!ftech.value.nom) {
      this.techError = '*Ce champs ne doit pas être vide';
      console.log('Error:champs nom vide!');
      return 0;
    }
    this.technologieService.postTechnologie(ftech.value.nom, ftech.value.status).subscribe(res => {
      this.afficheTechCat();
      ftech.controls.nom.reset();
      ftech.controls.status.reset();

    });

  }

  removeTechnologie(id) {
    console.log(id);
    this.technologieService.deleteTechnologie(id).subscribe((data) => {
      this.afficheTechCat();
    });
  }

  removeCategorie(id) {
    console.log(id);
    this.categorieService.deleteCategorie(id).subscribe((data) => {
      this.afficheTechCat();
    });

  }

  showInputTech(id) {
    this.showInputT = id;
  }
  showTech(id) {
    this.showInputT = 0;
  }
  showInputCat(id) {
    this.showInputC = id;
  }
  showCat(id) {
    this.showInputC = 0;
  }
  putCategorie(nom, id) {

      console.log(nom);
      if (nom) {
        this.categorieService.putCategorie(nom, id).subscribe(res => {
          this.afficheTechCat();
        });
        this.showInputC = 0;

      }

  }

  putTechnologie(nom, status, id) {
    console.log(nom, status, id);
    if (nom) {
      this.technologieService.putTechnologie(nom, !!status, id).subscribe(res => {
        this.afficheTechCat();
      });
      this.showInputT = 0;

    }
  }
}
