import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { MatDialog } from '@angular/material/dialog';
import { AdicionarLivroComponent } from './components/adicionar-livro/adicionar-livro.component';
import { SucessoDialogComponent } from './components/sucesso-dialog/sucesso-dialog.component';
import { LivroService } from '../../services/livro.service';
import { LivroCardComponent } from "./components/livro-card/livro-card.component";
import { Livro } from '../../model/Livro';
import { CommonModule } from '@angular/common';
import { UsuarioService } from '../../services/usuario.service';
import { Usuario } from '../../model/Usuario';
import { faUser, faRightFromBracket } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { DialogRef } from '@angular/cdk/dialog';
import { ConfirmarSairDialogComponent } from './components/confirmar-sair-dialog/confirmar-sair-dialog.component';
import { Router } from '@angular/router';
import { EditUserDialogComponent } from './components/edit-user-dialog/edit-user-dialog.component';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [LivroCardComponent, CommonModule, FontAwesomeModule],
  templateUrl: './home.component.html',
  styleUrl: './home.component.css'
})
export class HomeComponent implements OnInit {
  faUser = faUser;
  faExit = faRightFromBracket;


  constructor(
    private authService: AuthService, 
    private dialog: MatDialog, 
    private livroService: LivroService,
    private usuarioService: UsuarioService,
    private router: Router
  ) {}

  livros: Livro[] = [];
  usuario: Usuario = new Usuario("", "");
  usuarioNome: string = '';
  totalLivrosLidos: number = 0;
  totalLivrosNaoLidos: number = 0;

  ngOnInit(): void {
    this.preencherInfo();
  }

  preencherInfo() {
    this.preencherLivros();
  
    this.usuarioService.buscaUsuarioLogado().subscribe((usuario: Usuario) => {
      this.usuario = usuario;
      this.usuarioNome = usuario.nome;
    });
  }

  preencherLivros() {
    this.livroService.buscarTodosLivrosUsuario().subscribe({
      next: (livros) => {
        this.livros = livros;
        this.contarLivros(); 
      },
      error: (error) => {
        console.error('Erro ao buscar livros do usuário:', error);
      }
    });
  }

  contarLivros() {
    this.totalLivrosLidos = 0;
    this.totalLivrosNaoLidos = 0;

    for (let livro of this.livros) {
      if (livro.status === 'Finalizado') {
        this.totalLivrosLidos++;
      } else if (livro.status === 'Pendente' || livro.status === 'Estou Lendo') {
        this.totalLivrosNaoLidos++;
      }
    }
  }

  adicionarLivro() {
    const dialogRef = this.dialog.open(AdicionarLivroComponent, {
      width: '900px',
      data: {}  
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        this.ngOnInit();
        this.dialog.open(SucessoDialogComponent, {
          data: { message: 'Livro adicionado com sucesso!'}
        });
      }
    });
  }

  onLivroAtualizado(result: boolean): void {
    if (result) {
      this.ngOnInit(); 
    }
  }

  onLogout() {
    const dialogRef = this.dialog.open(ConfirmarSairDialogComponent, {
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        this.authService.logout();
        this.router.navigate(['/login']);
      }
    });
  }

  onEditUser() {
    const dialogRef = this.dialog.open(EditUserDialogComponent, {
      data: this.usuario 
    });
  
    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        this.ngOnInit();
      }
    });
  }
  
}


