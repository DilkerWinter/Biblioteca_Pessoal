import { Component } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { MatDialogRef } from '@angular/material/dialog';
import { Livro } from '../../../../model/Livro';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { AuthService } from '../../../../services/auth.service';
import { LivroService } from '../../../../services/livro.service';
import { ConfirmarDialogComponent } from '../confirmar-dialog/confirmar-dialog.component';

@Component({
  selector: 'app-adicionar-livro',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './adicionar-livro.component.html',
  styleUrls: ['./adicionar-livro.component.css']
})
export class AdicionarLivroComponent {
  
  livro: Livro = new Livro("","","",0,"","",0);

  defaultImageUrl: string = 'https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png';

  constructor(
    public dialogRef: MatDialogRef<AdicionarLivroComponent>, 
    private dialog: MatDialog,
    private authService: AuthService, 
    private livroService: LivroService
  ) {}

  fecharDialog(): void {
    this.dialogRef.close();
  }

  onSubmit(): void {
    if (!this.livro.urlimagem) {
      this.livro.urlimagem = this.defaultImageUrl;
    }

    this.livro.usuarioId = Number(this.authService.getSessionToken());
    console.log(this.livro);
    
    const dialogRef = this.dialog.open(ConfirmarDialogComponent);

    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        this.livroService.adicionarLivro(this.livro).subscribe({
          next: (response) => {
            console.log('Livro adicionado com sucesso!', response);
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
