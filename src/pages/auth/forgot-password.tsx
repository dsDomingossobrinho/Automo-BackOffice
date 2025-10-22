import {
	AlertCircle,
	ArrowLeft,
	CheckCircle2,
	Info,
	Mail,
	Send,
} from "lucide-react";
import { type FormEvent, useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { Alert, AlertDescription } from "@/components/ui/alert";
import { Button } from "@/components/ui/button";
import {
	Card,
	CardContent,
	CardDescription,
	CardHeader,
	CardTitle,
} from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { useAuthStore } from "../../stores/authStore";

/**
 * Forgot Password Page Component
 * Request password reset OTP
 */
export default function ForgotPasswordPage() {
	const navigate = useNavigate();
	const { forgotPassword, isLoading, error, clearError } = useAuthStore();

	const [emailOrContact, setEmailOrContact] = useState("");
	const [localError, setLocalError] = useState<string | null>(null);
	const [successMessage, setSuccessMessage] = useState<string | null>(null);

	const handleSubmit = async (e: FormEvent) => {
		e.preventDefault();
		setLocalError(null);
		setSuccessMessage(null);
		clearError();

		// Basic validation
		if (!emailOrContact.trim()) {
			setLocalError("Por favor, digite seu email ou contacto");
			return;
		}

		try {
			const response = await forgotPassword(emailOrContact);

			if (response.success) {
				setSuccessMessage(response.message);
				// Navigate to reset password page after 2 seconds
				setTimeout(() => {
					navigate("/reset-password");
				}, 2000);
			} else {
				setLocalError(response.message);
			}
		} catch (err: any) {
			setLocalError(err.message || "Erro ao solicitar recuperação de senha");
		}
	};

	return (
		<div className="min-h-screen flex items-center justify-center bg-linear-to-br from-blue-500 to-purple-500 p-4">
			<Card className="w-full max-w-md shadow-2xl">
				<CardHeader className="space-y-2 text-center">
					<div className="mx-auto w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-2">
						<Mail className="w-8 h-8 text-primary" />
					</div>
					<CardTitle className="text-3xl font-bold">Recuperar Senha</CardTitle>
					<CardDescription className="text-base">
						Digite seu email ou contacto para receber o código de recuperação
					</CardDescription>
				</CardHeader>

				<CardContent>
					<form onSubmit={handleSubmit} className="space-y-4">
						{/* Error Display */}
						{(localError || error) && (
							<Alert variant="destructive">
								<AlertCircle className="h-4 w-4" />
								<AlertDescription>{localError || error}</AlertDescription>
							</Alert>
						)}

						{/* Success Message */}
						{successMessage && (
							<Alert className="bg-green-50 border-green-200 dark:bg-green-900/20 dark:border-green-800">
								<CheckCircle2 className="h-4 w-4 text-green-600 dark:text-green-400" />
								<AlertDescription className="text-green-800 dark:text-green-200">
									{successMessage}
								</AlertDescription>
							</Alert>
						)}

						{/* Email/Contact Field */}
						<div className="space-y-2">
							<Label htmlFor="email" className="flex items-center gap-2">
								<Mail className="w-4 h-4" />
								Email ou Contacto
							</Label>
							<Input
								type="text"
								name="email"
								placeholder="Digite seu email ou contacto"
								value={emailOrContact}
								onChange={(e) => setEmailOrContact(e.target.value)}
								required
								autoComplete="email"
								autoFocus
								disabled={isLoading || !!successMessage}
								className="h-11"
							/>
						</div>

						{/* Submit Button */}
						<Button
							type="submit"
							className="w-full h-11 text-base"
							disabled={isLoading || !!successMessage}
						>
							{isLoading ? (
								<>
									<div className="mr-2 h-4 w-4 animate-spin rounded-full border-2 border-current border-t-transparent" />
									Enviando...
								</>
							) : successMessage ? (
								<>
									<CheckCircle2 className="mr-2 h-4 w-4" />
									Código Enviado
								</>
							) : (
								<>
									<Send className="mr-2 h-4 w-4" />
									Enviar Código
								</>
							)}
						</Button>

						{/* Back to Login */}
						<div className="text-center pt-2">
							<Link
								to="/login"
								className="text-sm text-muted-foreground hover:text-primary transition-colors inline-flex items-center gap-1"
							>
								<ArrowLeft className="w-3.5 h-3.5" />
								Voltar ao login
							</Link>
						</div>

						{/* Info Notice */}
						<Alert className="bg-blue-50 border-blue-200 dark:bg-blue-900/20 dark:border-blue-800">
							<Info className="h-4 w-4 text-blue-600 dark:text-blue-400" />
							<AlertDescription className="text-blue-800 dark:text-blue-200 text-sm">
								Você receberá um código de 6 dígitos por email ou SMS
							</AlertDescription>
						</Alert>
					</form>
				</CardContent>
			</Card>
		</div>
	);
}
