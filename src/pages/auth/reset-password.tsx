import {
	AlertCircle,
	ArrowLeft,
	CheckCircle2,
	Clock,
	Eye,
	EyeOff,
	Info,
	Key,
	Lock,
} from "lucide-react";
import { type FormEvent, useEffect, useState } from "react";
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
 * Reset Password Page Component
 * Verify OTP and set new password
 */
export default function ResetPasswordPage() {
	const navigate = useNavigate();
	const { resetPassword, tempForgotPassword, isLoading, error, clearError } =
		useAuthStore();

	const [otpCode, setOtpCode] = useState("");
	const [newPassword, setNewPassword] = useState("");
	const [confirmPassword, setConfirmPassword] = useState("");
	const [showPassword, setShowPassword] = useState(false);
	const [localError, setLocalError] = useState<string | null>(null);
	const [successMessage, setSuccessMessage] = useState<string | null>(null);

	// Redirect if no temp forgot password
	useEffect(() => {
		if (!tempForgotPassword) {
			navigate("/forgot-password");
		}
	}, [tempForgotPassword, navigate]);

	const handleSubmit = async (e: FormEvent) => {
		e.preventDefault();
		setLocalError(null);
		setSuccessMessage(null);
		clearError();

		// Basic validation
		if (!otpCode.trim()) {
			setLocalError("Por favor, digite o código OTP");
			return;
		}

		if (otpCode.length !== 6) {
			setLocalError("O código OTP deve ter 6 dígitos");
			return;
		}

		if (!newPassword.trim()) {
			setLocalError("Por favor, digite a nova senha");
			return;
		}

		if (newPassword.length < 6) {
			setLocalError("A senha deve ter pelo menos 6 caracteres");
			return;
		}

		if (newPassword !== confirmPassword) {
			setLocalError("As senhas não coincidem");
			return;
		}

		try {
			const response = await resetPassword(
				otpCode,
				newPassword,
				confirmPassword,
			);

			if (response.success) {
				setSuccessMessage(response.message);
				// Navigate to login after 2 seconds
				setTimeout(() => {
					navigate("/login");
				}, 2000);
			} else {
				setLocalError(response.message);
			}
		} catch (err: unknown) {
			setLocalError(
				err instanceof Error ? err.message : "Erro ao redefinir senha",
			);
		}
	};

	return (
		<div className="min-h-screen flex items-center justify-center bg-linear-to-br from-blue-500 to-purple-500 p-4">
			<Card className="w-full max-w-md shadow-2xl">
				<CardHeader className="space-y-2 text-center">
					<div className="mx-auto w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-2">
						<Lock className="w-8 h-8 text-primary" />
					</div>
					<CardTitle className="text-3xl font-bold">Redefinir Senha</CardTitle>
					<CardDescription className="text-base">
						Digite o código recebido e sua nova senha
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

						{/* Info Message */}
						{tempForgotPassword?.emailOrContact && (
							<Alert className="bg-blue-50 border-blue-200 dark:bg-blue-900/20 dark:border-blue-800">
								<Info className="h-4 w-4 text-blue-600 dark:text-blue-400" />
								<AlertDescription className="text-blue-800 dark:text-blue-200 text-sm">
									Código enviado para{" "}
									<strong>{tempForgotPassword.emailOrContact}</strong>
								</AlertDescription>
							</Alert>
						)}

						{/* OTP Code Field */}
						<div className="space-y-2">
							<Label htmlFor="otp" className="flex items-center gap-2">
								<Key className="w-4 h-4" />
								Código OTP
							</Label>
							<Input
								type="text"
								name="otp"
								placeholder="000000"
								value={otpCode}
								onChange={(e) =>
									setOtpCode(e.target.value.replace(/\D/g, "").slice(0, 6))
								}
								required
								maxLength={6}
								autoFocus
								disabled={isLoading || !!successMessage}
								className="h-12 text-center text-xl tracking-[0.4em] font-mono"
							/>
						</div>

						{/* New Password Field */}
						<div className="space-y-2">
							<Label htmlFor="newPassword" className="flex items-center gap-2">
								<Lock className="w-4 h-4" />
								Nova Senha
							</Label>
							<div className="relative">
								<Input
									type={showPassword ? "text" : "password"}
									name="newPassword"
									placeholder="Digite sua nova senha"
									value={newPassword}
									onChange={(e) => setNewPassword(e.target.value)}
									required
									disabled={isLoading || !!successMessage}
									className="h-11 pr-10"
								/>
								<Button
									type="button"
									variant="ghost"
									size="sm"
									onClick={() => setShowPassword(!showPassword)}
									disabled={isLoading || !!successMessage}
									className="absolute right-0 top-0 h-11 w-11 px-3 hover:bg-transparent"
								>
									{showPassword ? (
										<EyeOff className="h-4 w-4 text-muted-foreground" />
									) : (
										<Eye className="h-4 w-4 text-muted-foreground" />
									)}
								</Button>
							</div>
							<p className="text-xs text-muted-foreground">
								Mínimo de 6 caracteres
							</p>
						</div>

						{/* Confirm Password Field */}
						<div className="space-y-2">
							<Label
								htmlFor="confirmPassword"
								className="flex items-center gap-2"
							>
								<Lock className="w-4 h-4" />
								Confirmar Senha
							</Label>
							<Input
								type={showPassword ? "text" : "password"}
								name="confirmPassword"
								placeholder="Confirme sua nova senha"
								value={confirmPassword}
								onChange={(e) => setConfirmPassword(e.target.value)}
								required
								disabled={isLoading || !!successMessage}
								className="h-11"
							/>
						</div>

						{/* Submit Button */}
						<Button
							type="submit"
							className="w-full h-11 text-base"
							disabled={isLoading || !!successMessage || otpCode.length !== 6}
						>
							{isLoading ? (
								<>
									<div className="mr-2 h-4 w-4 animate-spin rounded-full border-2 border-current border-t-transparent" />
									Redefinindo...
								</>
							) : successMessage ? (
								<>
									<CheckCircle2 className="mr-2 h-4 w-4" />
									Senha Redefinida
								</>
							) : (
								<>
									<CheckCircle2 className="mr-2 h-4 w-4" />
									Redefinir Senha
								</>
							)}
						</Button>

						{/* Back Link */}
						<div className="text-center pt-2">
							<Link
								to="/forgot-password"
								className="text-sm text-muted-foreground hover:text-primary transition-colors inline-flex items-center gap-1"
							>
								<ArrowLeft className="w-3.5 h-3.5" />
								Voltar
							</Link>
						</div>

						{/* Security Notice */}
						<Alert className="bg-amber-50 border-amber-200 dark:bg-amber-900/20 dark:border-amber-800">
							<Clock className="h-4 w-4 text-amber-600 dark:text-amber-400" />
							<AlertDescription className="text-amber-800 dark:text-amber-200 text-xs">
								O código expira em 15 minutos
							</AlertDescription>
						</Alert>
					</form>
				</CardContent>
			</Card>
		</div>
	);
}
