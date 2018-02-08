class Test:
    def prt(self):
        print(self)
        print(self.__class__)

    def tao(s):
        print(s)
        print(s.__class__)

t = Test()
t.prt()

print();
t.tao()