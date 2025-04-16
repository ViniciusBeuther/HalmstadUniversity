import numpy as np
import matplotlib.pyplot as plt

## Question 01.1
def f(x):
    return 5 * x + 2

def g(x):
    return 6 * (x ** 2)

def h(x):
    return np.cos(2*x + 6) / np.e ** (6*x)

x = np.arange(-2,2,.1)
#plt.figure(figsize=(10, 6))

plt.plot(x, f(x),'r--', label='f(x) = 5x + 2')
plt.plot(x, g(x),'y--', label='g(x) = 6 * (x^2)')
plt.plot(x, h(x), 'b--', label='h(x) = cos(2x + 6) / e ^ (6x)')
plt.legend()
plt.grid(True)

plt.ylim(-5, 30)
plt.show()

