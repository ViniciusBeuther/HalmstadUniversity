# 2.3 Plot the derivatives and the original functions overlaid
import sympy as sym
import matplotlib.pyplot as plt
import numpy as np

x_sym = sym.symbols('x')

# set function expressions
f_exp = sym.sin(x_sym) / x_sym
g_exp = 1 / (1 + sym.exp(-x_sym))


# get derivative expressions
df_exp = sym.diff(f_exp, x_sym)
dg_exp = sym.diff(g_exp, x_sym)


# convert to numpy function
f = sym.lambdify(x_sym, f_exp, modules=['numpy'])
df = sym.lambdify(x_sym, df_exp, modules=['numpy'])
g = sym.lambdify(x_sym, g_exp, modules=['numpy'])
dg = sym.lambdify(x_sym, dg_exp, modules=['numpy'])


# generate x values
x = np.linspace(-10, 10, 300)

# calculate derivatives
f_val = f(x)
df_val = df(x)
g_val = g(x)
dg_val = dg(x)

# Plotting values
plt.figure(figsize=(15, 5))


# plot the function and its derivative
plt.subplot(1,2,1)
plt.plot(x, f_val,'g--', label='f(x) = sin(x) / x')
plt.plot(x, df_val,'b--', label='f(x) = sin(x) / x')
plt.title('Plot f(x) / f\'(x)')
plt.legend()
plt.grid(True)


# plot g(x) and its derivative
plt.subplot(1, 2, 2)
plt.plot(x, g_val, 'y-', label='g(x) = 6x^2')
plt.plot(x, dg_val, 'g--', label="g'(x) = 12x")
plt.title('Plot g(x) / g\'(x)')
plt.legend()
plt.grid(True)


plt.tight_layout()
plt.show()
