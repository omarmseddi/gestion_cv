import { FormModule } from './form.module';

describe('CvModule', () => {
    let formModule: FormModule;

    beforeEach(() => {
        formModule = new FormModule();
    });

    it('should create an instance', () => {
        expect(formModule).toBeTruthy();
    });
});
