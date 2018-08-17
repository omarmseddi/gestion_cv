import {ICategorie} from './categorie';
import {ITechnologie} from './technologie';
import {UploadFile} from 'ngx-uploader';

export interface ICV {
  id: number;
  idsp: number;
  type: string;
  nom: string;
  prenom: string;
  categorie: string;
  mission: boolean;
  disponibilite: boolean;
  technologie: string[];
  numItems: number;
  file: string;
  fileName: string;
  fichier: UploadFile;

}
