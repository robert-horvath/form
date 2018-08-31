#!/usr/bin/env python2.7

import os
import yaml
import string
import shutil


# ==================
# Template functions
# ==================
def tmplClass():
  return string.Template("""<?php
declare(strict_types = 1);
namespace $namespace;

$useRHoUIList$useRHoForm

class $class extends $extends
{$__construct$getterFunctions
}""")


def tmplConstructFunction():
  return string.Template("""\n\n    public function __construct(array $$ui)
    {
        parent::__construct($$ui, [
$constructFields
        ]);
    }\n\n""")


def tmplGetterFnction():
  return string.Template("    public function $func(): $return { return $$this->in('$field')$index; }")


def tmplUIFunction():
  return string.Template("            '$fieldName' => function ($$x) { return $className::$func($$x$argv); }")


def getGetterFuncReturnAndIndexValues(v):
  if isinstance(v, dict): 
    i, r = v.items()[0]
    i = '->' + i
  else:
    i, r = ['', v]
  return { 'return': r, 'index': i }


def createGetterFunction(field, func, v):
  d = getGetterFuncReturnAndIndexValues(v)
  d.update({'func': func, 'field': field})
  return tmplGetterFnction().substitute(d)


def getConstructUIFuncValues(k1, k2):
  i = k2.find("(")
  j = k2.find(")")
  o = 1 if k2[0] == '?' else 0
  cn = k2 if o == 0 else k2[1:]
  return {
    'fieldName': k1,
    'argv': '' if i < 0 else ',' + k2[i + 1:j],
    'func': 'optional' if o == 1 else 'mandatory',
    'className': cn if i < 0 else cn[0:cn.find("(")]
  }


def buildClass(dict, dir, file):
  uiList = []
  constructFields = []
  getterFuncArr = []

  print "Building: " + getNamespace(dir) + '\\' + getClassName(file)
  for k1, v1 in dict.items():  # k1=userid, k1=authorization
    k2, v2 = v1.items()[0]  # k2=AlphaNumToken(32), k2=Authorization
    d = getConstructUIFuncValues(k1, k2)
    uiList.append(d['className'])
    constructFields.append(tmplUIFunction().substitute(d))
    for k3, v3 in v2.items():  # k3=userID, k3=token, k3=dateTime
      getterFuncArr.append(createGetterFunction(k1, k3, v3))  # v3=createdAt: \DateTime, v3=string

  return tmplClass().substitute({
    'namespace': getNamespace(dir),
    'class': getClassName(file),
    'extends': getExtendsClass(file),
    '__construct': getConstructorFunc(constructFields),
    'useRHoUIList': getUseRHoUIList(uiList),
    'useRHoForm': getUseRHoForm(dir, file),
    'getterFunctions' : getGetterFunctions(getterFuncArr)
  })


def getUseRHoForm(dir, file):
  return '\nuse RHo\\Form\\' + getExtendsClass(file) + ';' if getNamespace(dir) != 'RHo\\Form' else ''


def getGetterFunctions(getterFuncArr):
  return '' if len(getterFuncArr) == 0 else "\n\n".join(getterFuncArr)


def getUseRHoUIList(uiList):
  return '' if len(uiList) == 0 else "use RHo\UI\ { " + ", ".join(uiList) + " };"


def getConstructorFunc(constructFields):
  return '' if len(constructFields) == 0 else tmplConstructFunction().substitute({ 'constructFields': ",\n".join(constructFields) })


def getNamespace(dir):
  return '\\'.join(['RHo\Form'] + dir.split('/')[1:])


def getClassName(file):
  f = os.path.splitext(file)[0]
  return f if f[0] != '_' else f[1:] 


def getExtendsClass(file):
  f = os.path.splitext(file)[0]
  return 'AbstractProtectedForm' if f[0] == '_' else 'AbstractForm' 


def readYamlFile(f):
  print "Reading file: " + f
  dict = yaml.load(open(f, 'r'))
  return dict if not dict is None else {}


def savePhpFile(f, data):
  php = open(f, 'w')  
  print "Saving php class to: " + f
  php.write(data)
  php.close()


def getPhpAbsFilePath(dir, file):
  path = dir.split(os.path.sep)[1:]
  path.insert(0, 'src')
  path.append(file + '.php')
  return os.getcwd() + os.path.sep + os.path.sep.join(path)

  
def writePhpFile(dir, file, txt):
  f = getPhpAbsFilePath(dir, getClassName(file))
  d = os.path.dirname(f)
  if not os.path.exists(d):
    os.makedirs(d)
  savePhpFile(f, txt)

  
def createForm(dir, file):
    print "--- Create Form ---"
    dict = readYamlFile(os.path.join(dir, file))
    txt = buildClass(dict, dir, file)
    writePhpFile(dir, file, txt)


def main():
  # Change working dir to location of scipt file
  workingDir = os.path.dirname(os.path.realpath(__file__))
  os.chdir(workingDir)
  print "Working directory: " + os.getcwd()
  
  # Delete old PHP classes
  shutil.rmtree('src', True)
  print "Deleting 'src' folder"
  
  # Loop through all yaml files under 'cfg' folder
  for subdir, dirs, files in os.walk('cfg'):
    for file in files:
      if file.endswith(".yml"):
        createForm(subdir, file)


##### MAIN #####
if __name__ == '__main__':
  main()
