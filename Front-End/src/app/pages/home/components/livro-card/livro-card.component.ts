import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { Livro } from '../../../../model/Livro';
import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { faPen } from '@fortawesome/free-solid-svg-icons';
import { NgClass } from '@angular/common';
import { MatDialog } from '@angular/material/dialog';
import { EditarLivroDialogComponent } from '../editar-livro-dialog/editar-livro-dialog.component';

@Component({
  selector: 'app-livro-card',
  standalone: true,
  imports: [FontAwesomeModule, NgClass,],
  templateUrl: './livro-card.component.html',
  styleUrl: './livro-card.component.css'
})
export class LivroCardComponent implements OnInit {

  faPen = faPen;

  titulo: string = "";
  autor: string = "";
  comentario: string = "";
  nota: number = 0;
  status: string = "";
  urlImagem: string = "";  

  @Input() livro!: Livro;
  @Output() livroAtualizado = new EventEmitter<boolean>();
  
  constructor(private dialog: MatDialog){}

  ngOnInit(): void {
    this.preencherCard();
  }

  preencherCard() {
    if (this.livro) {
      this.titulo = this.livro.titulo;
      this.autor = this.livro.autor;  
      this.comentario = this.livro.comentario;
      this.nota = this.livro.nota;  
      this.status = this.livro.status;
      this.urlImagem = this.livro.urlimagem;
    } else {
      console.log('Livro is undefined or null');
    }
  }

  onEditCard() {
    const dialogRef = this.dialog.open(EditarLivroDialogComponent, {
      data: this.livro
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        this.livroAtualizado.emit(result);
      }
    });
  }
}

