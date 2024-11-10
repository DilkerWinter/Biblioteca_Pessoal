import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialog, MatDialogRef } from '@angular/material/dialog';
import { Usuario } from '../../../../model/Usuario';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { UsuarioService } from '../../../../services/usuario.service';
import { ConfirmarDialogComponent } from '../confirmar-dialog/confirmar-dialog.component';
import { ErrorDialogComponent } from '../error-dialog/error-dialog.component'; // Import the ErrorDialogComponent

@Component({
  selector: 'app-edit-user-dialog',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './edit-user-dialog.component.html',
  styleUrls: ['./edit-user-dialog.component.css']
})
export class EditUserDialogComponent {

  usuario: Usuario = new Usuario("","");
  nomeOriginal: string = "";

  constructor(private dialog: MatDialog, private usuarioService: UsuarioService, 
              public dialogRef: MatDialogRef<EditUserDialogComponent>, 
              @Inject(MAT_DIALOG_DATA) public data: Usuario) { 
    this.usuario = data;
    this.nomeOriginal = data.nome;
  }

  onSubmit() {
    const dialogRef = this.dialog.open(ConfirmarDialogComponent);
  
    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        if (this.usuario.nome !== this.nomeOriginal) {
          this.usuarioService.nomeUsuarioJaExiste(this.usuario.nome).subscribe(exists => {
            if (exists) {
              // Open the ErrorDialogComponent with the appropriate error message
              this.dialog.open(ErrorDialogComponent, {
                data: { message: 'Nome de usuário já existe! Escolha outro nome.' }
              });
            } else {
              this.updateUsuario();
            }
          }, error => {
            console.error('Erro ao verificar nome de usuário:', error);
          });
        } else {
          this.updateUsuario();
        }
      } else {
        console.log('Ação de edição cancelada');
      }
    });
  }
  
  private updateUsuario() {
    this.usuarioService.editarUsuario(this.usuario).subscribe(response => {
      this.dialogRef.close(true);
    }, error => {
      console.error('Erro ao atualizar usuário:', error);
    });
  }
}
