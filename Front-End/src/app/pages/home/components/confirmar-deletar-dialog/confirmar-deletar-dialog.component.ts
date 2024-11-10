import { Component } from '@angular/core';
import { MatDialogRef } from '@angular/material/dialog';

@Component({
  selector: 'app-confirmar-deletar-dialog',
  standalone: true,
  imports: [],
  templateUrl: './confirmar-deletar-dialog.component.html',
  styleUrl: './confirmar-deletar-dialog.component.css'
})
export class ConfirmarDeletarDialogComponent {
  constructor(public dialogRef: MatDialogRef<ConfirmarDeletarDialogComponent>) {}


  onCancel(): void {
    this.dialogRef.close(false);
  }

  onConfirm(): void {
    this.dialogRef.close(true);
  }
}
