import { Component } from '@angular/core';
import { MatDialogRef } from '@angular/material/dialog';

@Component({
  selector: 'app-confirmar-sair-dialog',
  standalone: true,
  imports: [],
  templateUrl: './confirmar-sair-dialog.component.html',
  styleUrl: './confirmar-sair-dialog.component.css'
})
export class ConfirmarSairDialogComponent {
  constructor(public dialogRef: MatDialogRef<ConfirmarSairDialogComponent>) {}


  onCancel(): void {
    this.dialogRef.close(false);
  }

  onConfirm(): void {
    this.dialogRef.close(true);
  }
}
