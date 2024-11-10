import { Component, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA, MatDialog } from '@angular/material/dialog';
import { Livro } from '../../../../model/Livro';
import { AuthService } from '../../../../services/auth.service';
import { LivroService } from '../../../../services/livro.service';
import { ConfirmarDialogComponent } from '../confirmar-dialog/confirmar-dialog.component';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ConfirmarDeletarDialogComponent } from '../confirmar-deletar-dialog/confirmar-deletar-dialog.component';

@Component({
  selector: 'app-editar-livro-dialog',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './editar-livro-dialog.component.html',
  styleUrl: './editar-livro-dialog.component.css'
})
export class EditarLivroDialogComponent {

  livro: Livro = new Livro("","","",0,"","",0);

  defaultImageUrl: string = 'https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png';


  constructor(
    private dialog: MatDialog,
    private authService: AuthService, 
    private livroService: LivroService,
    public dialogRef: MatDialogRef<EditarLivroDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: Livro
  ) {
    this.livro = data;
  }

  onSubmit(): void {
    if (!this.livro.urlimagem) {
      this.livro.urlimagem = this.defaultImageUrl;
    }
    const dialogRef = this.dialog.open(ConfirmarDialogComponent);

    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        this.livroService.editarLivro(this.livro).subscribe({
          next: (response) => {
            this.dialogRef.close(true);
          },
          error: (error) => {
            this.dialogRef.close(false);
          }
        });
      } 
    });
  }

  fecharDialog(): void {
    this.dialogRef.close();
  }

  onDelete(){
    const dialogRef = this.dialog.open(ConfirmarDeletarDialogComponent);

    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        this.livroService.deletarLivro(this.livro.id).subscribe({
          next: (response) => {
            console.log('Livro deletado com sucesso!', response);
            this.dialogRef.close(true);
          },
          error: (error) => {
            console.error('Erro ao adicionar livro', error);
            this.dialogRef.close(false);
          }
        });
      } 
    });
  }
}
