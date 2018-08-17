import {Component, OnInit} from '@angular/core';
import {AjouterCvService} from '../../../shared/services/ajouterCv.service';
import {ICategorie} from '../categorie';
import {ITechnologie} from '../technologie';
import {NgForm, FormGroup} from '@angular/forms';
import {ICV} from '../cvs';
import {routerTransition} from '../../../router.animations';


@Component({
  selector: 'app-CV',
  templateUrl: './ajouterCv.component.html',
  styleUrls: ['./ajouterCv.component.scss'],
  animations: [routerTransition()]
})
export class AjouterCvComponent implements OnInit {
  categories: ICategorie;
  fileSize: string;
  technologies: ITechnologie[];
  attachmentFile: File;
  file64: any;
  catError: string;
  techError: string;
  nomError: string;
  prenomError: string;
  image: any;

  constructor(private categorieService: AjouterCvService,
              private  technologieService: AjouterCvService,
              private  cvService: AjouterCvService) {
  }

  ngOnInit(): void {
    this.categorieService.getCategorie()
      .subscribe(categories => {
        this.categories = categories['hydra:member'];
      });
    this.technologieService.getTechnologie()
      .subscribe(technologies => {
        this.technologies = technologies;
        // console.log(this.technologies);
      });
  }

  onChange(event: EventTarget) {

    this.fileSize = '';
    const eventObj: MSInputMethodContext = <MSInputMethodContext> event;
    const target: HTMLInputElement = <HTMLInputElement> eventObj.target;
    const files: FileList = target.files;
    console.log(files);
    this.attachmentFile = files[0];
    console.log(this.attachmentFile);
    if (files[0].size >= 10097152) {
      this.fileSize = 'max file size is 10MB';
    }
    // console.log(this.formData);
    // this.formData.append('file', this.attachmentFile);
    // console.log(this.formData);
  }

  readData(input: any) {
    let f: File = input.target.files[0];
    let reader: FileReader = new FileReader();
    reader.readAsDataURL(f);
    reader.onload = () => {
      this.image = reader.result;

    };
  }


  onSubmit(f: NgForm) {
    console.log(f.value);
    console.log(this.image);

    let formData = new FormData();
    if (this.image != '')
      formData.append('file', this.image, this.image.name);
    formData.append('cv', JSON.stringify(f.value));


    this.cvService.postCv(
      f.value.nom, f.value.prenom, formData, f.value.categorie, f.value.mission,
      f.value.disponibilite, f.value.technologie).subscribe();
  }

}
