import {
	AlertCircle,
	ArrowLeft,
	CheckCircle2,
	Clock,
	Info,
	Key,
} from "lucide-react";
import { type FormEvent, useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
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
import { useVerifyOtp } from "../../hooks/useAuth";
import { useAuthStore } from "../../stores/authStore";

/**
 * OTP Verification Page Component
 * Migrated from PHP app/Views/auth/otp.php
 * Now using React Query mutation for better state management
 */
export default function OTPPage() {
	const navigate = useNavigate();
	const tempLogin = useAuthStore((state) => state.tempLogin);
	const verifyOtpMutation = useVerifyOtp();

	const [otpCode, setOtpCode] = useState("");
	const [validationError, setValidationError] = useState<string | null>(null);

	// Redirect if no temp login (with delay to allow state to load from storage)
	useEffect(() => {
		const timer = setTimeout(() => {
			if (!tempLogin) {
				console.log("No tempLogin found, redirecting to login");
				navigate("/login");
			}
		}, 100); // Small delay to allow Zustand persist to restore state

		return () => clearTimeout(timer);
	}, [tempLogin, navigate]);

	const handleSubmit = async (e: FormEvent) => {
		e.preventDefault();
		setValidationError(null);

		// Basic validation
		if (!otpCode.trim()) {
			setValidationError("Por favor, digite o código OTP");
			return;
		}

		if (otpCode.length !== 6) {
			setValidationError("O código OTP deve ter 6 dígitos");
			return;
		}

		verifyOtpMutation.mutate(otpCode);
	};

	const handleBackToLogin = () => {
		navigate("/login");
	};

	const errorMessage = validationError || verifyOtpMutation.error?.message;
	const successMessage = verifyOtpMutation.isSuccess
		? verifyOtpMutation.data?.message
		: null;

	return (
		<div className="min-h-screen flex items-center justify-center bg-linear-to-br from-blue-500 to-purple-500 p-4">
			<Card className="w-full max-w-md shadow-2xl">
				<CardHeader className="space-y-2 text-center">
					<div className="mx-auto w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-2">
						<Key className="w-8 h-8 text-primary" />
					</div>
					<CardTitle className="text-3xl font-bold">Verificação OTP</CardTitle>
					<CardDescription className="text-base">
						Digite o código de 6 dígitos enviado para seu email/SMS
					</CardDescription>
				</CardHeader>

				<CardContent>
					<form onSubmit={handleSubmit} className="space-y-4">
						{/* Success Message */}
						{successMessage && (
							<Alert className="bg-green-50 border-green-200 dark:bg-green-900/20 dark:border-green-800">
								<CheckCircle2 className="h-4 w-4 text-green-600 dark:text-green-400" />
								<AlertDescription className="text-green-800 dark:text-green-200">
									{successMessage}
								</AlertDescription>
							</Alert>
						)}

						{/* Error Display */}
						{errorMessage && (
							<Alert variant="destructive">
								<AlertCircle className="h-4 w-4" />
								<AlertDescription>{errorMessage}</AlertDescription>
							</Alert>
						)}

						{/* Info Message */}
						{!successMessage && tempLogin?.emailOrContact && (
							<Alert className="bg-blue-50 border-blue-200 dark:bg-blue-900/20 dark:border-blue-800">
								<Info className="h-4 w-4 text-blue-600 dark:text-blue-400" />
								<AlertDescription className="text-blue-800 dark:text-blue-200 text-sm">
									Um código de verificação foi enviado para{" "}
									<strong>{tempLogin.emailOrContact}</strong>
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
								disabled={verifyOtpMutation.isPending}
								className="h-14 text-center text-2xl tracking-[0.5em] font-mono"
							/>
							<p className="text-xs text-muted-foreground text-center">
								Digite o código de 6 dígitos
							</p>
						</div>

						{/* Submit Button */}
						<Button
							type="submit"
							className="w-full h-11 text-base"
							disabled={verifyOtpMutation.isPending || otpCode.length !== 6}
						>
							{verifyOtpMutation.isPending ? (
								<>
									<div className="mr-2 h-4 w-4 animate-spin rounded-full border-2 border-current border-t-transparent" />
									Verificando...
								</>
							) : (
								<>
									<CheckCircle2 className="mr-2 h-4 w-4" />
									Verificar Código
								</>
							)}
						</Button>

						{/* Resend OTP */}
						<div className="text-center space-y-2 pt-2">
							<p className="text-sm text-muted-foreground">
								Não recebeu o código?
							</p>
							<Button
								type="button"
								variant="ghost"
								size="sm"
								onClick={handleBackToLogin}
								disabled={verifyOtpMutation.isPending}
								className="text-primary hover:text-primary/80"
							>
								<ArrowLeft className="mr-2 h-3.5 w-3.5" />
								Voltar ao Login
							</Button>
						</div>

						{/* Security Notice */}
						<Alert className="bg-amber-50 border-amber-200 dark:bg-amber-900/20 dark:border-amber-800">
							<Clock className="h-4 w-4 text-amber-600 dark:text-amber-400" />
							<AlertDescription className="text-amber-800 dark:text-amber-200 text-xs">
								O código expira em 5 minutos
							</AlertDescription>
						</Alert>
					</form>
				</CardContent>
			</Card>
		</div>
	);
}
