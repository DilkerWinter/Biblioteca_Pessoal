import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { UsuarioService } from '../../services/usuario.service';
import { Usuario } from '../../model/Usuario';
import { HttpClient, HttpClientModule } from '@angular/common/http';

@Component({
  selector: 'app-registrar',
  standalone: true,
  imports: [CommonModule, FormsModule,],
  templateUrl: './registrar.component.html',
  styleUrl: './registrar.component.css'
})
export class RegistrarComponent {
nome: string = '';
  password: string = '';
  confirmPassword: string = '';

  constructor(private router: Router, private usuarioService: UsuarioService) {}

  onSubmit() {
    if (this.password !== this.confirmPassword) {
      console.log(this.password);
      console.log(this.confirmPassword);
      alert("As senhas não coincidem.");
      return;
    }


    const novoUsuario = new Usuario(this.nome, this.password);

    this.usuarioService.registrar(novoUsuario).subscribe({
      next: (response) => {
        alert('Conta criada com sucesso!');
        this.router.navigate(['/login']);
      },
      error: (error) => {
        console.error(error);
        alert('Erro ao criar conta. Tente novamente.');
      }
    });
  }

}