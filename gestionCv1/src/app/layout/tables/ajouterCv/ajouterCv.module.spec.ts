import {AjouterCvModule} from './ajouterCv.module';

describe('AjouterCvModule', () => {
  let ajouter_cvModule: AjouterCvModule;

  beforeEach(() => {
    ajouter_cvModule = new AjouterCvModule();
  });

  it('should create an instance', () => {
    expect(ajouter_cvModule).toBeTruthy();
  });
});
